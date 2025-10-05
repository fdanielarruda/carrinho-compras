<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->string('payment_method', 50)->nullable();
            $table->unsignedSmallInteger('installments')->default(1);
            $table->decimal('subtotal_value', 10, 2);
            $table->decimal('discount_value', 10, 2)->default(0.00);
            $table->decimal('increment_value', 10, 2)->default(0.00);
            $table->decimal('final_value', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('carts');
    }
};
