<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return User::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'cpf' => 'required|string|unique:users,cpf',
            'age' => 'required|integer',
            'password' => 'required|string',
        ]);

        $data['password'] = bcrypt($data['password']);
        $user = User::create($data);
        return response()->json($user, 201);
    }

    public function search(Request $request)
    {
        $query = User::query();

        if ($request->has('name')) {
            $query->where('name', 'like', "%{$request->name}%");
        }

        if ($request->has('email')) {
            $query->where('email', $request->email);
        }

        if ($request->has('cpf')) {
            $query->where('cpf', $request->cpf);
        }

        
        $users = $query->with(['applications.job.company'])->get();

        return response()->json($users);
    }
}