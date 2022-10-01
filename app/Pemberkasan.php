<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pemberkasan extends Model
{
    //
    protected $table = 'pemberkasan';

    public function pendaftaran(){
        return $this->belongsTo(Pendaftaran::class);
    }
}
