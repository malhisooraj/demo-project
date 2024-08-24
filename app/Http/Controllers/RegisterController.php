<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RegisterController extends Controller
{
    public function create()
    {
        return view('register.create');
    }

    public function store(Request $request)
    {

        $attributes = $request->validate([
            'name' => 'required|max:255',
            //'username' => 'required|min:3|max:255|unique:users,username',
            'username' => ['required', 'min:3', 'max:255', Rule::unique('users', 'username')],
            'email' => 'required|email|max:255|unique:users,email', // unique, on table users and column email
            'password' => ['required', 'min:7', 'max:255'],
        ]);

        //$attributes['password'] = bcrypt($attributes['password']);

        $user = User::create($attributes);

        if ($user->email == 'soorajmalhi+superadmin@gmail.com') {
            $role = Role::findOrCreate('super-admin');
            $user->assignRole('super-admin');
        }

        auth()->login($user);

        //session()->flash('success', 'Your account has been created!'); // add flash message in session
        // same as ->with('success', 'Your account has been created!')

        return redirect('/')->with('success', 'Your account has been created!');
    }
}
