<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InnerPart extends Model
{
    use HasFactory;

    protected $table = 'tbl_inner_part';

    protected $fillable = [
        'Image_ip',
        'size_ip',
        'logo_ip',
        'label_ip',
        'type_ip',
        'Qty_ip',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    
    // Relasi ke Part jika diperlukan
    public function parts()
    {
        return $this->hasMany(Part::class, 'inner_id');
    }
    public function orders()
    {
        return $this->hasMany(Order::class, 'id_inner_part', 'id');
    }
}
