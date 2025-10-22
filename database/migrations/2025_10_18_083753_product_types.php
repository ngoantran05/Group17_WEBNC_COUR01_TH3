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
        Schema::create('product_types', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Tên loại (vd: Áo thun)
            $table->string('slug')->unique(); // (vd: ao-thun)
            
            // Thêm khóa ngoại nếu bạn muốn liên kết Loại với Danh mục
            // Vd: "Áo thun" thuộc danh mục "Áo"
            $table->foreignId('category_id')->nullable()->constrained('categories')->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_types');
    }
};
