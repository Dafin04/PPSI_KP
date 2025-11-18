<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kerja_prakteks', function (Blueprint $table) {
            if (!Schema::hasColumn('kerja_prakteks', 'progress_status')) {
                $table->string('progress_status')->nullable()->after('riwayat_bimbingan');
            }

            if (!Schema::hasColumn('kerja_prakteks', 'progress_status_updated_at')) {
                $table->timestamp('progress_status_updated_at')->nullable()->after('progress_status');
            }
        });
    }

    public function down(): void
    {
        Schema::table('kerja_prakteks', function (Blueprint $table) {
            if (Schema::hasColumn('kerja_prakteks', 'progress_status_updated_at')) {
                $table->dropColumn('progress_status_updated_at');
            }

            if (Schema::hasColumn('kerja_prakteks', 'progress_status')) {
                $table->dropColumn('progress_status');
            }
        });
    }
};
