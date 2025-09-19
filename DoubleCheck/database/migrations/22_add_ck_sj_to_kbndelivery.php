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
        Schema::table('tbl_kbndelivery', function (Blueprint $table) {
            $table->boolean('check_sj')->default(false);
            $table->dateTime('time_sj')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_kbndelivery', function (Blueprint $table) {
            $table->dropColumn('check_sj');
            $table->dropColumn('time_sj');
        });
    }
};
