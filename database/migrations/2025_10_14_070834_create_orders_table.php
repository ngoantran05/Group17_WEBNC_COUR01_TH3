<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(){
        Schema::create('orders', function(Blueprint $table){
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('order_number')->unique();
            $table->decimal('total_amount',12,2)->default(0);
            $table->text('shipping_address')->nullable();
            $table->string('phone')->nullable();
            $table->enum('payment_method',['COD','Online'])->default('COD');
            $table->enum('status',['pending','confirmed','processing','shipped','delivered','cancelled'])->default('pending');
            $table->timestamps();
        });

        Schema::create('order_items', function(Blueprint $table){
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained();
            $table->integer('quantity');
            $table->decimal('unit_price',12,2);
            $table->string('size')->nullable();
            $table->string('color')->nullable();
            $table->timestamps();
        });
    }
    public function down(){
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
    }
};
