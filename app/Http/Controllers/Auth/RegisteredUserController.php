<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;

use App\Models\User;
use App\Models\Profile;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('account.login');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        if ($request->form_type == 'app') {

            $userGuard = User::where('id', 1)->orWhere('email', 'admin@site.kz')->first();
            $values = explode('/', $userGuard->profile->about);

            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'lastname' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'tel' => ['required', 'string', 'max:15', 'unique:users'],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
                'code' => ['required', Rule::in($values)],
            ]);
        } else {

            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'lastname' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]);
        }

        $user = User::create([
            'name' => $request->name,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'tel' => $request->tel ?? null,
            'password' => Hash::make($request->password),
        ]);

        $profile = new Profile;
        $profile->user_id = $user->id;
        $profile->region_id = 1;
        $profile->save();
 
        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
