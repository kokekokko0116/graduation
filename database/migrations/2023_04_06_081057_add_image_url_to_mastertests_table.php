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
        Schema::table('mastertests', function (Blueprint $table) {
            $table->text('image_url')->nullable(); // 画像URLを格納するカラムを追加
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mastertests', function (Blueprint $table) {
            $table->dropColumn('image_url'); // 画像URLカラムを削除
        });
    }
};
