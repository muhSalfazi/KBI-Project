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
        Schema::create('tbl_parts', function (Blueprint $table) {
            $table->id();
            $table->string('P_Name');
            $table->string('P_No')->unique();
            $table->string('cust_part_no')->unique();
            $table->string('img_p')->nullable();
            $table->string('size')->nullable();
            $table->string('lbl_img')->nullable();
            $table->string('pos_label')->nullable();
            $table->unsignedBigInteger('inner_id')->nullable();
            $table->unsignedBigInteger('outer_id')->nullable();
            $table->boolean('status')->default(1);
            
            // FK
            $table->foreign('inner_id')
            ->references('id')
            ->on('tbl_inner_part')
            ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('outer_id')
            ->references('id')
            ->on('tbl_outer_part')
            ->onDelete('cascade')->onUpdate('cascade');

            // timetamps
            $table->timestamps();
             // Soft Deletes
            // $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_parts');
    }
};