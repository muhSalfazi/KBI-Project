<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class Part extends Model
{
    use HasFactory;

    protected $table = 'tbl_parts';

    protected $fillable = [
        'P_Name', 
        'P_No', 
        'cust_part_no',
        'customer_id', 
        'img_p', 
        'size', 
        'lbl_img', 
        'pos_label', 
        'inner_id', 
        'outer_id',
        'status'
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    /**
     * Relasi ke tabel Planning
     */
    public function planning()
    {
        return $this->hasMany(Planning::class, 'id_part', 'id');
    }

    /**
     * Relasi ke tabel Orders
     */
        public function orders()
        {
            return $this->hasMany(Order::class, 'id_part', 'id');
        }

    /**
     * Relasi ke tabel Customer
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    /**
     * Relasi ke tabel InnerPart
     */
    public function innerPart()
    {
        return $this->belongsTo(InnerPart::class, 'inner_id', 'id');
    }

    /**
     * Relasi ke tabel OuterPart
     */
    public function outerPart()
    {
        return $this->belongsTo(OuterPart::class, 'outer_id', 'id');
    }
    
}
