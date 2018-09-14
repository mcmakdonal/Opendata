<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrganizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_organization', function (Blueprint $table) {
            $table->increments('ogz_id');
            $table->string('ogz_title', 255);
            $table->string('ogz_url', 255);
            $table->string('ogz_description', 500);
            $table->char('ogz_status', 2);
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
        Schema::dropIfExists('tbl_organization');
    }
}
