<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivityLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->string('action_type');
            $table->string('request_url');
            $table->string('os');
            $table->string('browser');
            $table->string('robot');
            $table->string('device');
            $table->string('ip');
            $table->string('controller');
            $table->unsignedBigInteger('user_id');
            $table->string('status_code');
            $table->string('response_message');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activity_logs');
    }
}
