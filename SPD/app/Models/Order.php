<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'tbl_orders';
    protected $fillable = [
        'id_part',
        'id_inner_part',
        'id_outer_part',
        'customer_id',
        'P_order',
        'P_no_cus',
        'Qty',
        'delivery_date',
        'catatan',
        'status',
    ];
    
    protected $attributes = [
        'catatan' => 'tidak ada',
    ];
    protected $casts = [
        'delivery_date' => 'datetime',
        'created_at' => 'datetime',
    ];

    public function part()
    {
        return $this->belongsTo(Part::class, 'id_part', 'id'); // Relasi ke tabel parts
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    /**
     * Relasi ke tabel InnerPart
     */
        public function innerPart()
    {
        return $this->belongsTo(InnerPart::class, 'id_inner_part', 'id');
    }

    public function outerPart()
    {
        return $this->belongsTo(OuterPart::class, 'id_outer_part', 'id');
    }


    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
    public function planning()
    {
        return $this->hasMany(Planning::class, 'id_order','id');
    }


}
