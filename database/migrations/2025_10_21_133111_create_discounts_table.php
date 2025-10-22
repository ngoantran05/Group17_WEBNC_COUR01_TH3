<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // Mã (ví dụ: GIAM10)
            
            // 'percent' (giảm %) hoặc 'fixed' (giảm số tiền)
            $table->enum('type', ['percent', 'fixed']); 
            
            $table->decimal('value', 12, 0); // Giá trị (ví dụ: 10% hoặc 50000đ)
            
            $table->timestamp('expires_at')->nullable(); // Ngày hết hạn (có thể null)
            
            // Giới hạn số lượt sử dụng
            $table->integer('usage_limit')->nullable(); // Số lượt tối đa
            $table->integer('usage_count')->default(0); // Số lượt đã dùng
            
            $table->boolean('is_active')->default(true); // Bật/Tắt
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('discounts'); }
};
