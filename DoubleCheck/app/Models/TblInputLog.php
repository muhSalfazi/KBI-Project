<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class TblInputLog extends Model
{
    protected $table = 'tb_input_log';

    protected $fillable = [
        'customer_tbl',
        'no_dn',
        'process',
        'status',
        'scanned_by'
    ];

    public function scanByUser (){
        return $this->belongsTo(TblUser::class, 'scanned_by');
    }
}
