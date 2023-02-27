<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    //
    protected $table = 'pegawai';

    public function pendaftaran(){
        return $this->hasOne('App\pendaftaran');
    }   
    public function perangkatdaerah(){
        return $this->hasOne('App\perangkatdaerah');
    }
    protected $fillable = [
        'id', 'pd_id', 'pd', 'password',
    ];
}
