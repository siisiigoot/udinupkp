<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubUjian extends Model
{
    //
    protected $table = 'subujian';

    public function ujian(){
        return $this->belongsTo('App\Ujian', 'ujian_id', 'id');
    }
}
