<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OuterPart extends Model
{
    use HasFactory;

    protected $table = 'tbl_outer_part';

    protected $fillable = [
        'Image_op',
        'size_op',
        'logo_op',
        'label_op',
        'type_op',
        'Qty_op',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    // Relasi ke Part jika diperlukan
    public function parts()
    {
        return $this->hasMany(Part::class, 'outer_id');
    }
    public function orders()
    {
        return $this->hasMany(Order::class, 'id_outer_part', 'id');
    }
}
