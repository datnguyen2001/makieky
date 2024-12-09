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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_code');
            $table->integer('user_id');
            $table->string('name');
            $table->string('phone');;
            $table->integer('province_id')->nullable();
            $table->integer('district_id')->nullable();
            $table->string('ward_id')->nullable();
            $table->string('detail_address')->nullable();
            $table->integer('type_payment')->default(0)->comment('1 là thanh toán khi nhận hàng, 2 là vnpay ');
            $table->bigInteger('total_money');
            $table->integer('status')->default(0);
            $table->integer('is_select')->default(0)->comment('0 là chưa mua,1 là đã mua');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
