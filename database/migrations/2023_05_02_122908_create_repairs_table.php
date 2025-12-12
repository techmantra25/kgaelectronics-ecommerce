<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateRepairsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repairs', function (Blueprint $table) {
            $table->id();
            $table->string('dealer_user_name', 200)->nullable();
            $table->string('customer_name', 200)->nullable();
            $table->string('customer_phone', 12)->nullable();
            $table->string('bill_no', 250)->nullable();
            $table->string('product_value', 250)->nullable();
            $table->string('product_sl_no', 100)->nullable();
            $table->string('product_name', 250)->nullable();
            $table->text('remarks')->nullable();
            $table->string('snapshot_file', 100)->nullable();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('repairs');
    }
}
