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
        Schema::table('alat', function (Blueprint $table) {
            // Drop old string column if exists
            if (Schema::hasColumn('alat', 'foto_alat')) {
                $table->dropColumn('foto_alat');
            }
            // Add new json column
            $table->json('fotos')->nullable()->after('kondisi');
        });

        Schema::table('laboratorium', function (Blueprint $table) {
            $table->json('fotos')->nullable()->after('deskripsi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('alat', function (Blueprint $table) {
            $table->dropColumn('fotos');
            $table->string('foto_alat')->nullable();
        });

        Schema::table('laboratorium', function (Blueprint $table) {
            $table->dropColumn('fotos');
        });
    }
};
