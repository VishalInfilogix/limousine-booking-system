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
        Schema::table('vehicles', function (Blueprint $table) {
            $table->string('image', 250)->nullable()->change();
            $table->string('brand', 250)->nullable()->change();
            $table->string('model', 250)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->string('image', 250)->nullable(false)->change();
            $table->string('brand', 50)->nullable(false)->change();
            $table->string('model', 50)->nullable(false)->change();
        });
    }
};
