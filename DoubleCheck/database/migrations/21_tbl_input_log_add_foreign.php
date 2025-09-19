<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        DB::statement('
            ALTER TABLE tb_input_log
            MODIFY COLUMN scanned_by INT
        ');

        Schema::table('tb_input_log', function (Blueprint $table) {
            $table->foreign('scanned_by')->references('id_user')->on('tbl_user')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_input_log', function (Blueprint $table) {
            $table->dropForeign(['scanned_by']);
        });
    }
};
