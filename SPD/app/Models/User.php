<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Carbon\Carbon;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';


    protected $fillable = [
        'id',
        'username',
        'first_name',
        'last_name',
        'password',
        'role',
        'last_login',
        'id_card_number'
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'last_login' => 'datetime', // Ensure this is cast to a datetime
    ];

    public function hasRole($role)
    {
        return $this->role === $role;
    }


    public function isAdmin()
    {
        return $this->role === 'admin';
    }
    public function getLastLoginAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y H:i:s');
    }

}
