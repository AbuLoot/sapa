<?php

namespace App\Http\Livewire\Joystick;

use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

use Image;
use Storage;

use App\Models\Mode;
use App\Models\Product;
use App\Models\Category;
use App\Traits\ImageTrait;

class Joytable extends Component
{
    use WithPagination, WithFileUploads, ImageTrait;
 
    public $lang;
    public $products;
    public $product_index = null;
    public $idCodes = [];
    public $idCodesCount = [];
    public $categories = [];
    public $images = [];
    public $editMode;
    public $modesId = [];
    public $sortMode = false;
    public $sameProducts = [];
    public $productId;
    public $dataAlert = false;
    public $indexLive = null;

    protected $paginationTheme = 'bootstrap';

    protected $providers = ['reload' => '$refresh'];

    protected $rules = [
        'products.*.title' => 'required|min:2',
        'products.*.price' => 'numeric',
        // 'products.*.purchase_price' => 'numeric',
        // 'products.*.wholesale_price' => 'numeric',
        'products.*.count_web' => 'numeric',
        'products.*.category_id' => 'numeric',
        'products.*.modes_id' => 'numeric',
    ];

    public function mount()
    {
        $this->lang = app()->getLocale();
        $this->sameProducts = [];
        $this->idCodes = [];
        $this->idCodesCount = [];
        $this->productId = null;
        $this->indexLive = null;
    }

    public function editProduct()
    {
        $this->categories = Category::get()->toTree()->toArray();
        $this->editMode = true;
    }

    public function sortProducts()
    {
        $this->sortMode = true;
    }

    public function resortProducts()
    {
        $this->sortMode = false;
    }

    public function saveProduct()
    {
        // $this->validate();
        $this->editMode = false;
    }

    public function findByIdCode($idCode, $productId)
    {
        $this->sameProducts = Product::query()
            ->where('id', '!=', $productId)
            ->where('id_codes', 'like', '%'.$idCode.'%')
            ->get();

        $this->productId = $productId;

        if (empty($this->sameProducts)) {
            return;
        }

        $this->dataAlert = true;
        $this->indexLive = null;
    }

    public function deleteProduct($index)
    {
        $productLive = $this->sameProducts[$index];
        $productLive->delete();

        unset($this->sameProducts[$index]);
    }

    public function addField($indexLive)
    {
        $this->indexLive = $indexLive;
    }

    public function deleteField($index)
    {
        unset($this->barcodes[$index]);
        array_values($this->barcodes);
    }

    public function updated($key, $value)
    {
        $parts = explode('.', $key);

        // $idCodes = $this->products[$parts[1]]['idCodesData'];

        $this->resetErrorBag();

        if (count($parts) === 3) {

            $productLive = $this->products[$parts[1]];

            $product = Product::find($productLive['id']);

            if ($parts[0] == 'idCodes') {

                if (empty($value)) {
                    unset($this->idCodes[$parts[1]][$parts[2]]);
                    unset($this->idCodesCount[$parts[1]][$parts[2]]);

                    $idCodesData = array_combine($this->idCodes[$parts[1]], $this->idCodesCount[$parts[1]]);

                    $product->id_codes = json_encode($idCodesData);
                    $product->save();
                    $this->indexLive = null;
                    return;
                }

                $idCodes = $this->products[$parts[1]]['idCodesData'];

                $i = 0;
                $j = 0;

                foreach($this->idCodes[$parts[1]] as $key => $code) {

                    if ($key == $parts[2]) {
                        break;
                    }

                    $i++;
                }

                $idCodesData = [];
                $n = 0;

                foreach ($idCodes as $idCode => $count) {

                    if ($n == $i) {
                        $idCodesData[$value] = $this->idCodesCount[$parts[1]][$parts[2]];
                        $n++;
                        continue;
                    }

                    $idCodesData[$idCode] = $count;
                    $n++;
                }

                // $combined = collect($this->idCodes[$parts[1]])->combine($this->idCodesCount[$parts[1]]);
                // $idCodesCount = $combined->all();

                $product->id_codes = json_encode($idCodesData);
                $product->save();
                $this->indexLive = null;
                return;
            }

            if ($parts[0] == 'idCodesCount') {

                if (!is_numeric($value)) {
                    $this->addError($key, 'Invalid value');
                    return;
                }

                $idCodesCount = array_combine($this->idCodes[$parts[1]], $this->idCodesCount[$parts[1]]);

                $product->id_codes = json_encode($idCodesCount);
                $product->count_web = array_sum($idCodesCount);
                $product->save();
                return;
            }

            if ($parts[2] == 'modes_id') {
                $product->modes()->sync($value);
                return;
            }

            if (in_array($parts[2], ['title']) && empty($value)) {
                $this->addError($key, 'Invalid value');
                return;
            }

            if (in_array($parts[2], ['purchase_price', 'wholesale_price', 'price', 'count_web', 'category_id']) && !is_numeric($value)) {
                $this->addError($key, 'Invalid value');
                return;
            }

            $column = $parts[2];

            $product->$column = $value;
            $product->save();
        }
    }

    public function uploadImages($product_index)
    {
        // $this->validate();

        $product = $this->products[$product_index] ?? null;

        $editedProduct = Product::find($product['id']);

        // Adding new images
        if ($this->images) {

            $dirName = $product['path'];
            $images = unserialize($product['images']);

            // Create Directory
            if (!file_exists('img/products/'.$dirName) OR empty($dirName)) {
                $dirName = $product['category_id'].'/'.time();
                Storage::makeDirectory('img/products/'.$dirName);
                $editedProduct['path'] = $dirName;
            }

            $order = (!empty($images)) ? count($images) : 1;
            $order = time() + 1;

            foreach ($this->images as $key => $image)
            {
                $imageName = 'image-'.$order.'-'.Str::slug($product['title']).'.'.$image->getClientOriginalExtension();

                $watermark = Image::make('img/watermark.png');

                // Creating present images
                $this->resizeOptimalImage($image, 320, 290, '/img/products/'.$dirName.'/present-'.$imageName, 80);

                // Storing original images
                $this->resizeOptimalImage($image, 800, 600, '/img/products/'.$dirName.'/'.$imageName, 80, $watermark);

                $images[$key]['image'] = $imageName;
                $images[$key]['present_image'] = 'present-'.$imageName;
                $order++;
            }

            ksort($images);

            $introImage = current($images)['present_image'];
            $editedProduct->image = $introImage;
            $editedProduct->images = serialize($images);
            $editedProduct->save();
        }

        $this->product_index = null;
    }

    public function render()
    {
        // $productsItems = (auth()->user()->roles()->firstWhere('name', 'admin'))
        //     ? Product::orderBy('created_at','desc')->paginate(30)
        //     : Product::where('user_id', auth()->user()->id)->orderBy('created_at','desc')->paginate(30);

        $modes = Mode::get();

        $modesId = $this->modesId;

        $productsItems = Product::query()
            ->when($modesId, function($query) use ($modesId) {
                $query->whereHas('modes', function ($query) use ($modesId) {
                        $query->whereIn('mode_id', $modesId);
                    });
            })
            ->when(($this->sortMode == true), function($query) {
                $query->orderBy('category_id');
            }, function($query) {
                $query->orderByDesc('id');
            })
            ->paginate(50);

        $productsCount = Product::query()
            ->when($modesId, function($query) use ($modesId) {
                $query->whereHas('modes', function ($query) use ($modesId) {
                    $query->whereIn('mode_id', $modesId);
                });
            })
            ->count();

        if ($this->editMode) {

            $i = 0;

            $this->products = $productsItems->all();

            // dd($this->products, $productsItems->all());

            foreach($this->products as $index => $product) {

                $idCodesData = json_decode($product['id_codes'],  true);
                $idCodesData = empty($idCodesData) ? ['' => 0] : $idCodesData;

                $this->products[$index]['modes_id'] = $product->modes->pluck('id')->toArray();
                $this->products[$index]['idCodesData'] = $idCodesData;
                $productsItems[$index]['idCodesData'] = $idCodesData;

                foreach($idCodesData as $idCode => $count) {
                    $this->idCodes[$index][$i] = $idCode;
                    $this->idCodesCount[$index][$i] = $count ?? 0;
                    $i++;
                }

                if (!is_null($this->indexLive) && $this->indexLive == $index) {
                    $this->idCodes[$index][$i] = '';
                    $this->idCodesCount[$index][$i] = 0;
                    $idCodesData[''] = 0;
                    $i++;
                    $this->products[$index]['idCodesData'] = $idCodesData;
                    $productsItems[$index]['idCodesData'] = $idCodesData;
                    $this->indexLive = null;
                }
            }

            // dd($this->products);
        }

        return view('livewire.joystick.joytable', ['productsItems' => $productsItems, 'productsCount' => $productsCount, 'modes' => $modes]);
    }
}
