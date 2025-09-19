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
        DB::statement('ALTER TABLE `tbl_kbndelivery` CHANGE `checked_at` `checked_at` DATETIME NULL DEFAULT NULL AFTER `checked_by`');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('ALTER TABLE `tbl_kbndelivery` CHANGE `checked_at` `checked_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `checked_by`');
    }
};
