<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'tbl_messages';

    protected $fillable = ['content', 'sender'];

    public function senderName(){
        return $this->belongsTo(TblUser::class, 'sender');
    }
}
