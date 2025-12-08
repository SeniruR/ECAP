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
        if (Schema::hasTable('adm_u')) {
            Schema::dropIfExists('adm_u');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // recreate minimal adm_u table for rollback (if needed)
        if (!Schema::hasTable('adm_u')) {
            Schema::create('adm_u', function (Blueprint $table) {
                $table->bigIncrements('no');
                $table->string('adm_e', 200)->unique();
                $table->string('adm_p', 1000);
                $table->string('name', 200)->nullable();
                $table->timestamps();
            });
        }
    }
};
