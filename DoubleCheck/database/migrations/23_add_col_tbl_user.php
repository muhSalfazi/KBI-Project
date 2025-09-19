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
        Schema::table('tbl_user', function (Blueprint $table) {
            $table->integer('chance')->default(0);
            $table->boolean('is_blocked')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_user', function(Blueprint $table) {
            $table->dropColumn('chance');
            $table->dropColumn('is_blocked');
        });
    }
};
