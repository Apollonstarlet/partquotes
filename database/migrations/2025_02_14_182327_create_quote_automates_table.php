<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quote_automates', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('part', 255)->nullable();
            $table->string('make', 255)->nullable();
            $table->string('model', 255)->nullable();
            $table->string('year_from', 10)->nullable();
            $table->string('year_to', 10)->nullable();
            $table->unsignedBigInteger('price');
            $table->unsignedBigInteger('delivery');
            $table->string('condition', 255)->nullable();
            $table->string('guarantee', 255)->nullable();
            $table->string('supplier', 255)->nullable();
            $table->text('comment')->nullable();
            $table->text('private')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quote_automates');
    }
};
