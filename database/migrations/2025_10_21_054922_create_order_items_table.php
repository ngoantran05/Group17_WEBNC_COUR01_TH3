<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->foreignId('product_id')->nullable()->constrained('products')->onDelete('set null');
            
            // Lưu "snapshot" (ảnh chụp) thông tin sản phẩm tại thời điểm mua
            $table->string('product_name');
            $table->string('size_name')->nullable();
            $table->string('color_name')->nullable();
            $table->decimal('price', 12, 0);
            $table->integer('quantity');
            
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('order_items'); }
};