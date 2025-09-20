<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'tbl_customer';
    protected $fillable = 
    [
        'name',
        'username'
    ];

    // Definisi relasi ke model Part
    public function parts()
    {
        return $this->hasMany(Part::class, 'customer_id','id');
    }
}
