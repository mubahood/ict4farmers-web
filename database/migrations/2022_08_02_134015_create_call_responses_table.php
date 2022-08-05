<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCallResponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::drop('call_responses');

        Schema::create('call_responses', function (Blueprint $table) {
            $table->id();
            $table->string('district', 100);
            $table->integer('call_id');
            // $table->foreign('call_id')->nullable()->references('id')->on('calls')->onDelete('cascade');
            $table->string('agent', 100);
            $table->string('caller_name', 200)->nullable();
            $table->smallInteger('caller')->nullable();
            $table->string('type_of_question', 50)->nullable();
            $table->string('question')->nullable();
            $table->string('solution')->nullable();
            $table->integer('called_from');
            // $table->foreign('called_from')->nullable()->references('name')->on('districts')->nullOnDelete();
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
        Schema::dropIfExists('call_responses');
    }
}
