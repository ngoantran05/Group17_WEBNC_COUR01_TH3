<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\ProductType;
use App\Models\Size;
use App\Models\Color;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker; 

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // === BƯỚC 1: XÓA TẤT CẢ LỆNH TRUNCATE ===
        // DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        // Category::truncate();
        // ProductType::truncate();
        // ... (các lệnh truncate khác đã bị xóa)
        // DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        
        // === 2. TẠO DỮ LIỆU BẢNG PHỤ (DÙNG updateOrCreate) ===
        // Lệnh này sẽ "Tìm 'ao', nếu không có thì tạo mới"
        // Sẽ không bao giờ tạo trùng lặp
        
        $this->command->info('Updating/Creating default data (Categories, Sizes, Colors)...');

        $productNames = [
            'Áo Thun Basic Cotton', 'Áo Sơ Mi Lụa Tay Dài', 'Quần Jean Skinny Fit', 'Váy Hoa Nhí Vintage',
            'Áo Khoác Bomber Kaki', 'Quần Short Jean Nữ', 'Chân Váy Chữ A Công Sở', 'Giày Sneaker Cổ Cao',
            'Túi Xách Da Thật', 'Áo Len Cổ Lọ', 'Quần Kaki Ống Rộng', 'Đầm Dạ Hội Cúp Ngực',
            'Áo Polo Thể Thao', 'Áo Khoác Jean Bụi Bặm', 'Giày Cao Gót Mũi Nhọn', 'Quần Âu Nam Lịch Lãm'
        ];

        // Tạo Categories
        $cat1 = Category::updateOrCreate(['slug' => 'ao'], ['name' => 'Áo']);
        $cat2 = Category::updateOrCreate(['slug' => 'quan'], ['name' => 'Quần']);
        $cat3 = Category::updateOrCreate(['slug' => 'vay'], ['name' => 'Váy']);
        $cat4 = Category::updateOrCreate(['slug' => 'giay-dep'], ['name' => 'Giày dép']);
        $cat5 = Category::updateOrCreate(['slug' => 'phu-kien'], ['name' => 'Phụ kiện']);
        $categories = collect([$cat1, $cat2, $cat3, $cat4, $cat5]); // Thu thập để dùng ở dưới

        // Tạo Product Types
        $type1 = ProductType::updateOrCreate(['slug' => 'ao-thun'], ['name' => 'Áo thun']);
        $type2 = ProductType::updateOrCreate(['slug' => 'ao-len'], ['name' => 'Áo len']);
        $type3 = ProductType::updateOrCreate(['slug' => 'ao-khoac'], ['name' => 'Áo khoác']);
        $type4 = ProductType::updateOrCreate(['slug' => 'quan-jean'], ['name' => 'Quần jean']);
        $type5 = ProductType::updateOrCreate(['slug' => 'quan-short'], ['name' => 'Quần short']);
        $types = collect([$type1, $type2, $type3, $type4, $type5]); // Thu thập

        // Tạo Sizes
        $sizeS = Size::updateOrCreate(['name' => 'S']);
        $sizeM = Size::updateOrCreate(['name' => 'M']);
        $sizeL = Size::updateOrCreate(['name' => 'L']);
        $sizeXL = Size::updateOrCreate(['name' => 'XL']);
        $sizeXXL = Size::updateOrCreate(['name' => 'XXL']);
        $allSizeIds = [$sizeS->id, $sizeM->id, $sizeL->id, $sizeXL->id, $sizeXXL->id];

        // Tạo Colors
        $colorTrang = Color::updateOrCreate(['name' => 'Trắng'], ['hex_code' => '#FFFFFF']);
        $colorDen = Color::updateOrCreate(['name' => 'Đen'], ['hex_code' => '#000000']);
        $colorXam = Color::updateOrCreate(['name' => 'Xám'], ['hex_code' => '#808080']);
        $colorXanh = Color::updateOrCreate(['name' => 'Xanh'], ['hex_code' => '#0000FF']);
        $colorDo = Color::updateOrCreate(['name' => 'Đỏ'], ['hex_code' => '#FF0000']);
        $allColorIds = [$colorTrang->id, $colorDen->id, $colorXam->id, $colorXanh->id, $colorDo->id];

        
        // === 3. CHỈ TẠO SẢN PHẨM MẪU NẾU BẢNG TRỐNG ===
        $this->command->info('Checking product table...');

        if (Product::count() == 0) {
            $this->command->info('Product table is empty. Creating 30 sample products...');
            
            $faker = Faker::create();
            for ($i = 1; $i <= 30; $i++) {
                
                $name = $productNames[array_rand($productNames)] . ' Mẫu ' . $i;
                $price = rand(90000, 1000000);
                $category = $categories->random(); // Lấy ngẫu nhiên từ collection
                $type = $types->random(); // Lấy ngẫu nhiên từ collection

                $product = Product::create([
                    'name' => $name,
                    'slug' => Str::slug($name),
                    'description' => 'Đây là mô tả chi tiết cho ' . $name . '. Sản phẩm có chất lượng tốt, mẫu mã đẹp.',
                    'price' => $price,
                    'stock' => rand(0, 100),
                    'sold_quantity' => rand(0, 500), 
                    'main_image_url' => 'https://via.placeholder.com/300x300.png?text=Product+' . $i,
                    'is_active' => true,
                    'category_id' => $category->id,
                    'gender' => $faker->randomElement(['male', 'female', 'unisex']),
                    'product_type_id' => $type->id,
                ]);

                // Gán quan hệ
                $randomSizeIds = collect($allSizeIds)->random(rand(1, 3))->toArray();
                $product->sizes()->attach($randomSizeIds);
                $randomColorIds = collect($allColorIds)->random(rand(1, 2))->toArray();
                $product->colors()->attach($randomColorIds);
            }

            $this->command->info('Sample product seeding complete!');
        } else {
            // Nếu bảng products đã có dữ liệu (do bạn thêm từ admin)
            $this->command->info('Product table is not empty. Skipping sample product creation.');
        }
    }
}
