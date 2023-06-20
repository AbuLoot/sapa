<?php

namespace App\Http\Controllers\Joystick;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Joystick\Controller;

use App\Models\App;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use App\Models\Post;

class AdminController extends Controller
{
    public function index()
    {
        $count_apps = App::count();
        $count_users = User::count();
        $count_orders = Order::count();
        $count_posts = Post::count();
        $count_products = Product::count();

    	return view('joystick.index', compact('count_apps', 'count_posts', 'count_users', 'count_orders', 'count_products'));
    }

    public function filemanager()
    {
        if (! Gate::allows('allow-filemanager', \Auth::user())) {
            abort(403);
        }

    	return view('joystick.filemanager');
    }

    public function frameFilemanager()
    {
    	return view('joystick.frame-filemanager');
    }
}
