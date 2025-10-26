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
        Schema::table('investors', function (Blueprint $table) {
            $table->foreignId('dapur_id')->constrained('dapurs')->cascadeOnDelete()->before('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('investors', function (Blueprint $table) {
            //
        });
    }
};
