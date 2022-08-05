<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgentProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::drop("agent_profiles");

        Schema::create('agent_profiles', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->smallInteger('contact');
            $table->integer('region_id');
            // $table->foreign('region_id')->references('id')->on('regions')->onDelete('cascade');
            $table->integer('district_id');
            // $table->foreign('district_id')->references('id')->on('districts')->onDelete('cascade');
            $table->string('specific_role');
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
        Schema::dropIfExists('agent_profiles');
    }
}
