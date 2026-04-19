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
        Schema::create('alat', function (Blueprint $table) {
            $table->id();
            $table->string('nama_alat');
            $table->string('kode_alat')->unique();
            $table->foreignId('laboratorium_id')->constrained('laboratorium')->onDelete('cascade');
            $table->integer('stok')->default(0);
            $table->enum('kondisi', ['baik', 'rusak'])->default('baik');
            $table->enum('jenis_aset', ['lab', 'pribadi'])->default('lab');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alat');
    }
};
