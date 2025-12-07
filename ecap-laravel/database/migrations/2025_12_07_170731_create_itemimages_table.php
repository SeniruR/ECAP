<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('itemimages', function (Blueprint $table) {
            $table->bigIncrements('no');
            $table->unsignedBigInteger('itemno');
            $table->string('image', 1024);
            $table->timestamps();

            $table->foreign('itemno')->references('no')->on('items')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('itemimages');
    }
};
