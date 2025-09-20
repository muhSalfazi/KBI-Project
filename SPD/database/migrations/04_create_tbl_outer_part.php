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
        Schema::create('tbl_outer_part', function (Blueprint $table) {
            $table->id();
             // Outer Package
             $table->string('Image_op')->nullable();
             $table->string('size_op')->nullable();
             $table->string('logo_op')->nullable(); 
             $table->string('label_op')->nullable();
             $table->enum('type_op', ['pcs', 'pack', 'box'])->default('pcs');
             $table->integer('Qty_op')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_outer_part');
    }
};
