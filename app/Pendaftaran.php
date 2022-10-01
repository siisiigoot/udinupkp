<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    //
    protected $table = 'pendaftaran';


    public function pegawai(){
        return $this->belongsTo('App\Pegawai', 'pegawai_id', 'id');
    }    

    public function subujian(){
        return $this->belongsTo('App\SubUjian', 'subujian_id', 'id');
    }

    public function pengantar(){
        return $this->belongsTo('App\Pengantar', 'pengantar_id', 'id');
    }

    public function berkas(){
        return $this->hasMany(Pemberkasan::class);
    }
}
