<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
        'cpf',
        'age',
    ];

    // 🔹 Aqui é o que faltava
    public function applications()
    {
        return $this->hasMany(\App\Models\Application::class);
    }
}
