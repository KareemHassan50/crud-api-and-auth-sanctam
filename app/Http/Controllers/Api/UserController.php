<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return response($users);
    }
    public function show($id)
    {
        $user = User::findOrFail($id);
        return response($user);
    }
    public function store(Request $request)
    {
        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'data_of_birth' => $request->data_of_birth,
            'password' => Hash::make($request->password),
        ]);
        return response($user);
    }
    public function update($id, Request $request)
    {
        $user = User::findOrFail($id);
        $user->update($request->all());
        return response($user);
    }
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete($id);
        return response(null, 201, ['User Deleted successfully']);
    }
}