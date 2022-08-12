<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHcpRegitarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hcp_regitars', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('OccID')->nullable();
            $table->string('hcp')->nullable();
            $table->date('date');
            $table->string('round_palyed')->nullable();
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
        Schema::dropIfExists('hcp_regitars');
    }
}
