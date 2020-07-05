<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusinessTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('nik_id');
            $table->foreign('nik_id')->references('id')->on('agreements')->onDelete('cascade');

            $table->char('domisili_prov');
            $table->foreign('domisili_prov')->references('id')->on('provinces');
            $table->char('domisili_kab');
            $table->foreign('domisili_kab')->references('id')->on('regencies');
            $table->char('domisili_kec');
            $table->foreign('domisili_kec')->references('id')->on('districts');
            $table->char('domisili_desa');
            $table->foreign('domisili_desa')->references('id')->on('villages');
            $table->string('domisili_addr');

            $table->char('ktp_prov');
            $table->foreign('ktp_prov')->references('id')->on('provinces');
            $table->char('ktp_kab');
            $table->foreign('ktp_kab')->references('id')->on('regencies');
            $table->char('ktp_kec');
            $table->foreign('ktp_kec')->references('id')->on('districts');
            $table->char('ktp_desa');
            $table->foreign('ktp_desa')->references('id')->on('villages');
            $table->string('ktp_addr');

            $table->char('lapak_prov');
            $table->foreign('lapak_prov')->references('id')->on('provinces');
            $table->char('lapak_kab');
            $table->foreign('lapak_kab')->references('id')->on('regencies');
            $table->char('lapak_kec');
            $table->foreign('lapak_kec')->references('id')->on('districts');
            $table->char('lapak_desa');
            $table->foreign('lapak_desa')->references('id')->on('villages');
            $table->string('lapak_addr');
            
            $table->unsignedBigInteger('sector_id');
            $table->foreign('sector_id')->references('id')->on('sectors')->onDelete('cascade');
            $table->unsignedBigInteger('community_id')->nullable();
            $table->foreign('community_id')->references('id')->on('communities')->onDelete('cascade');
            $table->string('Business_specific');
            $table->string('waktu_jual');
            $table->string('status_kelompok');
            $table->boolean('is_active');
            $table->string('created_by', 50);
            $table->string('updated_by', 50)->nullable();
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
        Schema::dropIfExists('business');
    }
}
