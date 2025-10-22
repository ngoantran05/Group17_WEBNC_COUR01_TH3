<?php
namespace Database\Seeders;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('role', 'user')->get();
        $products = Product::all();

        if ($users->isEmpty() || $products->isEmpty()) {
            $this->command->info('Cần có user và product để tạo đơn hàng.');
            return;
        }

        $statuses = ['pending', 'processing', 'shipped', 'completed', 'cancelled'];
        
        for ($i = 0; $i < 20; $i++) {
            $user = $users->random();
            $totalAmount = 0;
            
            $order = Order::create([
                'user_id' => $user->id,
                'customer_name' => $user->name,
                'customer_phone' => '098765432' . $i,
                'customer_address' => '123 Đường Mẫu, Quận Mẫu, TP Mẫu',
                'total_amount' => 0,
                'status' => $statuses[array_rand($statuses)],
                'created_at' => now()->subDays(rand(0, 30))
            ]);

            $numItems = rand(1, 3);
            for ($j = 0; $j < $numItems; $j++) {
                $product = $products->random(); 
                $quantity = rand(1, 2);
                $price = $product->price;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $price,
                ]);
                $totalAmount += ($price * $quantity);
            }
            $order->update(['total_amount' => $totalAmount]);
        }
    }
}
