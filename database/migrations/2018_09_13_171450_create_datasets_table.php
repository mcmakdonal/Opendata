<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDatasetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_dataset', function (Blueprint $table) {
            $table->increments('dts_id');
            $table->integer('ogz_id');
            $table->string('dts_title', 255);
            $table->string('dts_url', 255);
            $table->string('dts_description', 500);
            $table->char('dts_status', 2);
            $table->integer('lcs_id');
            $table->dateTime('create_date');
            $table->integer('create_by');
            $table->dateTime('update_date');
            $table->integer('update_by');
            $table->char('record_status', 1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_dataset');
    }
}
