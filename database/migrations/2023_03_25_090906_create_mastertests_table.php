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
        Schema::create('mastertests', function (Blueprint $table) {
            $table->id();
            $table->string('series_number');
            $table->string('series_name');
            $table->string('number');
            $table->string('name');
            $table->text('price');
            $table->string('rarerity');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mastertests');
    }
};
