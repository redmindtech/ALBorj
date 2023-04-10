<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_masters', function (Blueprint $table) {
            $table->id();
            $table->integer('employee_no')->nullable();
            $table->string('firstname');
            $table->string('lastname');
            // $table->string('middlename');
            $table->string('fathername');
            $table->string('mothername');
            $table->date('join_date');
            $table->date('end_date');
            $table->string('category');
            $table->string('sponser');
            $table->string('working_as');
            $table->string('desigination');
            $table->string('depart');
            $table->string('status');
            $table->string('religion');
            $table->string('nationality');
            $table->string('city');
            $table->string('phone');
            $table->string('UAE_mobile_number');
            // $table->string('emergency_UAE_mobile_number');
            $table->string('pay_group');
            $table->string('accomodation');
            // $table->string('ticket_sector');
            $table->string('passport_no');
            $table->date('passport_expiry_date');
            $table->integer('emirates_id_no');
            $table->date('emirates_id_from_date');
            $table->date('emirates_id_to_date');


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
        Schema::dropIfExists('employee_masters');
    }
}
