<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateElementBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('element_banners', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('element_id');
            $table->string('title')->nullable();
            $table->string('text')->nullable();
            $table->string('href')->nullable();
            $table->string('button_text')->nullable();
            $table->string('picture')->nullable();
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
        Schema::dropIfExists('element_banners');
    }
}
