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
            $table->boolean('check_loading')->nullable();
            $table->integer('check_load_by')->nullable();
            $table->foreign('check_load_by')->references('id_user')->on('tbl_user')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_kbndelivery', function (Blueprint $table) {
            $table->dropColumn('check_loading');
            $table->dropColumn('check_load_by');
        });
    }
};
