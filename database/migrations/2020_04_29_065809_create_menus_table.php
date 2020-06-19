<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->integer('menu_parent');
            $table->string('menu_name', 100);
            $table->string('menu_url', 100)->nullable();
            $table->string('menu_uri', 30);
            $table->string('menu_target', 15)->nullable();
            $table->string('menu_group', 10);
            $table->boolean('menu_active')->default(true);
            $table->string('menu_icon', 100)->nullable();
            $table->string('created_by', 100);
            $table->string('updated_by', 100)->nullable();
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
        Schema::dropIfExists('menus');
    }
}
