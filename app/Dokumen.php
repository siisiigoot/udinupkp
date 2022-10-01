<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dokumen extends Model
{
    //
    protected $table = 'dokumen';
    
    public function ujian(){
        return $this->belongsTo('App\Ujian', 'ujian_id', 'id');
    }
}
