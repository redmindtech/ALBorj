<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_masters', function (Blueprint $table) {
            $table->increments('project_no');
            $table->integer('site_no');
            $table->string('site_name');
            $table->string('project_name');
            $table->string('project_type');
            $table->string('project_comments');
            $table->string('manager_name');
            $table->string('manager_contact_number');
            $table->string('company_name');
            $table->string('client_contact_name');
            $table->string('client_contact_number');
            $table->string('consultant_name');
            $table->date('start_date');
            $table->date('end_date');
            $table->date('actual_project_end_date');
            $table->string('status');
            $table->integer('total_price_cost');
            $table->integer('advanced_amount');
            $table->float('retention');
            $table->integer('amount_to_be_received');
            $table->integer('amount_return');
            $table->date('amount_return_date');
            $table->string('amount_returns_comment');

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
        Schema::dropIfExists('project_masters');
    }
}
