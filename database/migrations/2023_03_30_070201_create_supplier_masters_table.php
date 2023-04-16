<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupplierMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supplier_masters', function (Blueprint $table) {
            //$table->id();
            $table->id('supplier_no');
            $table->string('name');
            $table->string('company_name');
            $table->string('code');
            $table->string('address');
            $table->string('contact_number');
            $table->string('mail_id');
            $table->string('website');
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
        Schema::dropIfExists('supplier_masters');
    }
}