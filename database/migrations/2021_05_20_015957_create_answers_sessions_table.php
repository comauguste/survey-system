<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnswersSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::defaultStringLength(191);
        Schema::create('answers_sessions', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('session_uuid');
            $table->unsignedInteger('survey_id');
            $table->unsignedInteger('version');
            $table->text('request_info');
            $table->timestamps();
        });

        Schema::table('answers_sessions', function (Blueprint $table) {
            $table->foreign('survey_id')->references('id')->on('surveys')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('answers_sessions', function (Blueprint $table) {
            $table->dropForeign(['survey_id']);
        });
        Schema::dropIfExists('answers_sessions');
    }
}
