<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateCallsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calls', function (Blueprint $table) {
            // $table->id();
            $table->string('session_id', 200)->primary();
            $table->string('phone')->nullable();
            $table->dateTime('call_date')->nullable();
            $table->string('call_type')->nullable();
            // $table->enum('active', ['True', 'False'])->default("False");
            $table->boolean('active')->nullable();
            $table->string('recording_url')->nullable();
            $table->string('agent_phone')->nullable();
            $table->integer('call_duration')->nullable();
            $table->integer('call_menu_selected')->nullable();
            $table->string('language')->nullable();
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
        Schema::dropIfExists('calls');
    }
}
