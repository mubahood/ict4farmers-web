<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('counties', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->foreign('district_id', 200)->references('id')->on('regions')->onDelete('cascade');
            $table->timestamps();
        });
    }
    
    // 
    // name = models.CharField(max_length=100, null=False, blank=False)
    // district = models.ForeignKey(District, on_delete=models.CASCADE)
    // 



    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('counties');
    }
}
