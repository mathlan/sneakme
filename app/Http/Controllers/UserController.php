<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('user.admin',[
                'users' => $users
            ]
        );
    }

    public function show(User $user)
    {
        return view('user.show', [
            'user' => $user
        ]);
    }

    public function edit(User $user)
    {
        //$users = User::all();
        return view('user.edit',compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'lastname' => 'required|min:3|max:255',
            'firstname' => 'required|min:3|max:255',
            'email' => 'required|min:3|max:255',
        ]);

        $user->update($validatedData);

        return redirect()->route('users.index');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index');
    }
}
