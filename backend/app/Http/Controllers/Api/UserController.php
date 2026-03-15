<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class UserController extends Controller
{

    public function index()
    {
        return response()->json(
            User::paginate(10)
        );
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return response()->json($user, 201);
    }

    public function show($id)
    {
        return response()->json(
            User::findOrFail($id)
        );
    }

    public function update(Request $request, $id)
    {

        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'sometimes|string|max:100',
            'email' => 'sometimes|email',
            'password' => 'sometimes|min:6'
        ]);

        if ($request->name)
            $user->name = $request->name;

        if ($request->email)
            $user->email = $request->email;

        if ($request->password)
            $user->password = Hash::make($request->password);

        $user->save();

        return response()->json($user);
    }

    public function destroy($id)
    {

        User::findOrFail($id)->delete();

        return response()->json([
            "message" => "User deleted"
        ]);
    }
}
