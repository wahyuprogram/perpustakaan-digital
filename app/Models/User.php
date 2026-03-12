<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';
    
    // Memberitahu Laravel bahwa Primary Key kita adalah UserID
    protected $primaryKey = 'UserID'; 

    protected $fillable = [
        'Username',
        'Password',
        'Email',
        'NamaLengkap',
        'Alamat',
        'role',
    ];

    protected $hidden = [
        'Password',
        'remember_token',
    ];

    // Memberitahu Laravel untuk membaca kolom 'Password' (huruf besar) saat login
    public function getAuthPassword()
    {
        return $this->Password;
    }
}