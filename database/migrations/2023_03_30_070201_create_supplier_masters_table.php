<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupplierMastersTable extends Migration
{
    public function up()
    {
        Schema::create('supplier_masters', function (Blueprint $table) {
            $table->id('supplier_no');
            $table->string('name');
            $table->string('company_name');
            $table->string('code');
            $table->text('address');
            $table->string('contact_number');
            $table->string('mail_id');
            $table->string('website');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('supplier_masters');
    }
}