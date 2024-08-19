<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index()
    {
        return Inertia::render('User/UserView', ['users' => User::all()]);
    }


    // public function create() {}

    public function store(Request  $request)
    {
        $data = $request->validate([
            'name' => 'required|max:100|string',
            'email' => 'required|email|unique:users,email',
            'role' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        User::create($data);

        return to_route('users.index')->with('message', 'User CREATED Successfully');
    }

    public function update(Request $request, $id)
    {
        $data =  $request->validate([
            'name' => ['required', 'max:100'],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($id)],
            'role' => ['required']
        ]);

        User::whereId($id)->update($data);

        return to_route('users.index')->with('message', 'User UPDATED Successfully');
    }


    public function destroy($id)
    {
        User::destroy($id);

        to_route('users.index')->with('message', 'User has been DELETED');
    }
}
