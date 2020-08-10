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
            $table->string('name', 100);
            $table->unsignedBigInteger('nik_id');
            $table->foreign('nik_id')->references('id')->on('agreements')->onDelete('cascade');
            $table->string('business_name');
            $table->char('contact', 13);

            $table->char('lapak_kec');
            $table->foreign('lapak_kec')->references('id')->on('districts');
            $table->char('lapak_desa');
            $table->foreign('lapak_desa')->references('id')->on('villages');
            $table->string('lapak_addr');

            $table->string('mulai_jual');
            $table->string('selesai_jual');
            $table->unsignedBigInteger('sector_id');
            $table->foreign('sector_id')->references('id')->on('sectors')->onDelete('cascade');
            $table->unsignedBigInteger('community_id')->nullable();
            $table->foreign('community_id')->references('id')->on('communities')->onDelete('cascade');
            $table->string('status_kelompok');
            $table->boolean('is_active');
            $table->string('photo', 100)->nullable();
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
