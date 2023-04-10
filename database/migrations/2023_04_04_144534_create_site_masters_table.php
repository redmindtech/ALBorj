<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiteMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_masters', function (Blueprint $table) {
            $table->increments('site_no')->length(10);
            $table->string('site_name')->length(30);
            $table->string('site_location')->length(30);
            $table->string('site_building')->length(30);
            $table->string('site_floor')->length(30);
            $table->string('room_number')->length(30);
            $table->string('site_address')->length(300);
            $table->string('description')->length(500);
            $table->string('site_status')->length(20);
            $table->string('site_manager')->length(10);
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
        Schema::dropIfExists('site_masters');
    }
}
