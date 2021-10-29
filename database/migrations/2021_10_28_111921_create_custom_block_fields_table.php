<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomBlockFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('custom_block_fields', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('custom_block_id');
            $table->string('name');
            $table->string('preview_text')->nullable();
            $table->string('detail_text')->nullable();
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
        Schema::dropIfExists('custom_block_fields');
    }
}
