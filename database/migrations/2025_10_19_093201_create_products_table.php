<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(){
Schema::create('products', function (Blueprint $table){
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->decimal('price', 12, 0)->default(0); 
            $table->integer('stock')->default(0);
            $table->integer('sold_quantity')->unsigned()->default(0);
            $table->string('main_image_url')->nullable(); 
            $table->boolean('is_active')->default(true);

            
            $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
            
            
            $table->foreignId('product_type_id')->nullable()->constrained('product_types')->nullOnDelete();

            $table->timestamps();
            
            
        });;
    }
    public function down(){ Schema::dropIfExists('products'); }
};
