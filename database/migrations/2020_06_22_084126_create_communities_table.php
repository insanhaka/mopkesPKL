<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommunitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('communities', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('chairman_name', 100)->nullable();
            $table->bigInteger('chairman_nik')->nullable();

            $table->char('office_kec')->nullable();
            $table->foreign('office_kec')->references('id')->on('districts');
            $table->char('office_desa')->nullable();
            $table->foreign('office_desa')->references('id')->on('villages');
            $table->string('office_addr')->nullable();

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
        Schema::dropIfExists('communities');
    }
}
