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
        Schema::table('laboratorium', function (Blueprint $table) {
            $table->dropForeign(['master_id']);
            $table->unsignedBigInteger('master_id')->nullable()->change();
            $table->foreign('master_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('laboratorium', function (Blueprint $table) {
            $table->dropForeign(['master_id']);
            $table->unsignedBigInteger('master_id')->nullable(false)->change();
            $table->foreign('master_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
};
