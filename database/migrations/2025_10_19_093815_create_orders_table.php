<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            // user_id có thể null, cho phép khách vãng lai đặt hàng
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            
            // Thông tin người nhận
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('address');
            $table->string('province');
            $table->string('district');
            $table->string('ward');
            $table->text('note')->nullable();
            
            // Thông tin thanh toán
            $table->string('payment_method');
            $table->decimal('subtotal', 12, 0);
            $table->decimal('shipping_fee', 12, 0);
            $table->decimal('total', 12, 0);
            
            // Trạng thái
            $table->string('status')->default('pending'); // pending, processing, completed, cancelled
            
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('orders'); }
};
