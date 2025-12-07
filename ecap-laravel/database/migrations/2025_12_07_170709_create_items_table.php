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
        Schema::create('items', function (Blueprint $table) {
            $table->bigIncrements('no');
            $table->string('name', 200);
            $table->text('short_dis');
            $table->text('long_dis');
            $table->unsignedBigInteger('type')->nullable();
            $table->boolean('inactive_status')->default(false);
            $table->text('content')->nullable();
            $table->text('benefits')->nullable();
            $table->string('trademark', 255)->nullable();
            $table->decimal('price', 10, 2)->default(0);
            $table->timestamp('created')->useCurrent();
            $table->timestamps();

            $table->foreign('type')->references('no')->on('itemtypes')->cascadeOnUpdate()->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
