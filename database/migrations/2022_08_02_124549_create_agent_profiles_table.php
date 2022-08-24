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
            $table->string('name');
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('phone_number');
            $table->string('region');
            // $table->foreign('region_id')->references('id')->on('regions')->onDelete('cascade');
            $table->string('district');
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
