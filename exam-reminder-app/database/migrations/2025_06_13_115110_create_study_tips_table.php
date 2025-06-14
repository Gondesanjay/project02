<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('study_tips', function (Blueprint $table) {
            $table->id();
            $table->string('category');
            $table->text('tip');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('study_tips');
    }
};