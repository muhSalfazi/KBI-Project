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
        Schema::create('tbl_inner_part', function (Blueprint $table) {
            $table->id();
              // Inner Package
              $table->string('Image_ip')->nullable();
              $table->string('size_ip')->nullable();
              $table->string('logo_ip')->nullable();
              $table->string('label_ip')->nullable();
              $table->enum('type_ip', ['pcs', 'pack'])->default('pcs');
              $table->integer('Qty_ip')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_inner_part');
    }
};
