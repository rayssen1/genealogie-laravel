<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonParentTable extends Migration
{
    public function up()
    {
        Schema::create('person_parent', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('child_id');
            $table->unsignedBigInteger('parent_id');
            $table->timestamps();

            // Clés étrangères
            $table->foreign('child_id')->references('id')->on('people')->onDelete('cascade');
            $table->foreign('parent_id')->references('id')->on('people')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('person_parent');
    }
}

