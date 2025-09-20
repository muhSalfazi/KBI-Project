<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Planning extends Model
{
    use HasFactory;

        protected $table = 'tbl_packing';

        protected $fillable = [
            'id',
            'id_user',
            'id_order',
        ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'id_order');
    }

    // Relasi ke model User
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function part()
    {
        return $this->hasOneThrough(Part::class, Order::class, 'id', 'id', 'id_order', 'id_part');
    }
}
