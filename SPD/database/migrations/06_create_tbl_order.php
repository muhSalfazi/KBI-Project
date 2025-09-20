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
            Schema::create('tbl_orders', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('id_part')->nullable();
                 $table->unsignedBigInteger('customer_id')->nullable();
                $table->unsignedBigInteger('id_inner_part')->nullable();
                $table->unsignedBigInteger('id_outer_part')->nullable();
                $table->string('P_order');
                $table->string('P_no_cus');
                $table->string('Qty');
                $table->date('delivery_date')->nullable();
                $table->string('catatan')->default('tidak ada');
                $table->string('status')->default('open');
             
             
                $table->softDeletes(); 
                $table->timestamps();

                // Foreign key relationships
                $table->foreign('id_part')
                    ->references('id')
                    ->on('tbl_parts')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
                // inner
                $table->foreign('id_inner_part')
                    ->references('id')
                    ->on('tbl_inner_part')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
                // outer
                $table->foreign('id_outer_part')
                    ->references('id')
                    ->on('tbl_outer_part')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
                // customer
                $table->foreign('customer_id')
                ->references('id')
                ->on('tbl_customer')
                ->onDelete('cascade')->onUpdate('cascade');


            });
        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::table('tbl_orders', function (Blueprint $table) {
                $table->dropSoftDeletes();
            });
        }
    };
