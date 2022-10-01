<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePegawaiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pegawai', function (Blueprint $table) {
            $table->id();
            $table->string('nip',18);
            $table->string('gl_dpn',50)->nullable();
            $table->string('nama',100);
            $table->string('gl_blk',50)->nullable();
            $table->string('tmp_lhr',100)->nullable();
            $table->date('tgl_lhr')->nullable();
            $table->string('jk')->nullable();
            $table->string('gol_id')->nullable();
            $table->string('gol')->nullable();
            $table->date('gol_tmt')->nullable();
            $table->string('jns_jab_id')->nullable();
            $table->string('jns_jab')->nullable();
            $table->string('eselon_id')->nullable();
            $table->string('eselon')->nullable();
            $table->string('jab_id')->nullable();
            $table->string('jab')->nullable();
            $table->date('jab_tmt')->nullable();
            $table->string('ting_pend')->nullable();
            $table->string('unkerja_id')->nullable();
            $table->string('unkerja')->nullable();
            $table->string('pd_id')->nullable();
            $table->string('pd')->nullable();
            $table->string('instansi_id')->nullable();
            $table->string('instansi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pegawai');
    }
}
