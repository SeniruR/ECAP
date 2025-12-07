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
        Schema::create('itemtypes', function (Blueprint $table) {
            $table->bigIncrements('no');
            $table->string('name', 100);
            $table->boolean('inactive_status')->default(false);
            $table->text('short_discription')->nullable();
            $table->text('discription')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('itemtypes');
    }
};
