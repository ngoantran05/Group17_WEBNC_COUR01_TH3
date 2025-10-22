<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cart_id')->constrained('carts')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            
            // Liên kết với size và color (có thể null nếu sản phẩm không có)
            $table->foreignId('size_id')->nullable()->constrained('sizes')->onDelete('set null');
            $table->foreignId('color_id')->nullable()->constrained('colors')->onDelete('set null');

            $table->integer('quantity')->default(1);
            $table->decimal('price_snapshot', 12, 0); // Lưu giá tại thời điểm thêm vào giỏ

            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('cart_items'); }
};
