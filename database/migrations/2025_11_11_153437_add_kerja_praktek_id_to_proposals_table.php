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
    Schema::table('proposals', function (Blueprint $table) {
        $table->unsignedBigInteger('kerja_praktek_id')->nullable()->after('id');
        $table->foreign('kerja_praktek_id')->references('id')->on('kerja_prakteks')->onDelete('cascade');
    });
}

public function down(): void
{
    Schema::table('proposals', function (Blueprint $table) {
        $table->dropForeign(['kerja_praktek_id']);
        $table->dropColumn('kerja_praktek_id');
    });
}

};
