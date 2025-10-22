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
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Reset các bảng (xóa sạch dữ liệu cũ)
        Category::truncate();
        ProductType::truncate();
        Size::truncate();
        Color::truncate();
        Product::truncate();
        DB::table('product_size')->truncate();
        DB::table('color_product')->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        
        // === 1. TẠO DỮ LIỆU BẢNG PHỤ ===

        // === THÊM MỚI: Mảng tên sản phẩm thực tế ===
        $productNames = [
            'Áo Thun Basic Cotton', 'Áo Sơ Mi Lụa Tay Dài', 'Quần Jean Skinny Fit', 'Váy Hoa Nhí Vintage',
            'Áo Khoác Bomber Kaki', 'Quần Short Jean Nữ', 'Chân Váy Chữ A Công Sở', 'Giày Sneaker Cổ Cao',
            'Túi Xách Da Thật', 'Áo Len Cổ Lọ', 'Quần Kaki Ống Rộng', 'Đầm Dạ Hội Cúp Ngực',
            'Áo Polo Thể Thao', 'Áo Khoác Jean Bụi Bặm', 'Giày Cao Gót Mũi Nhọn', 'Quần Âu Nam Lịch Lãm'
        ];
        // ==========================================

        // Tạo Categories
        $cat1 = Category::create(['name' => 'Áo', 'slug' => 'ao']);
        $cat2 = Category::create(['name' => 'Quần', 'slug' => 'quan']);
        $cat3 = Category::create(['name' => 'Váy', 'slug' => 'vay']);
        $cat4 = Category::create(['name' => 'Giày dép', 'slug' => 'giay-dep']);
        $cat5 = Category::create(['name' => 'Phụ kiện', 'slug' => 'phu-kien']);

        // Tạo Product Types
        $type1 = ProductType::create(['name' => 'Áo thun', 'slug' => 'ao-thun']);
        $type2 = ProductType::create(['name' => 'Áo len', 'slug' => 'ao-len']);
        $type3 = ProductType::create(['name' => 'Áo khoác', 'slug' => 'ao-khoac']);
        $type4 = ProductType::create(['name' => 'Quần jean', 'slug' => 'quan-jean']);
        $type5 = ProductType::create(['name' => 'Quần short', 'slug' => 'quan-short']);

        // Tạo Sizes
        $sizeS = Size::create(['name' => 'S']);
        $sizeM = Size::create(['name' => 'M']);
        $sizeL = Size::create(['name' => 'L']);
        $sizeXL = Size::create(['name' => 'XL']);
        $sizeXXL = Size::create(['name' => 'XXL']);

        // Tạo Colors
        $colorTrang = Color::create(['name' => 'Trắng', 'hex_code' => '#FFFFFF']);
        $colorDen = Color::create(['name' => 'Đen', 'hex_code' => '#000000']);
        $colorXam = Color::create(['name' => 'Xám', 'hex_code' => '#808080']);
        $colorXanh = Color::create(['name' => 'Xanh', 'hex_code' => '#0000FF']);
        $colorDo = Color::create(['name' => 'Đỏ', 'hex_code' => '#FF0000']);

        // Lấy ID của các dữ liệu vừa tạo để dùng ở dưới
        $allSizeIds = [$sizeS->id, $sizeM->id, $sizeL->id, $sizeXL->id, $sizeXXL->id];
        $allColorIds = [$colorTrang->id, $colorDen->id, $colorXam->id, $colorXanh->id, $colorDo->id];

        
        // === 2. TẠO 30 SẢN PHẨM MẪU ===

        $this->command->info('Creating 30 sample products...');
        $faker = Faker::create();
        for ($i = 1; $i <= 30; $i++) {
            
            // === SỬA LẠI: Lấy tên ngẫu nhiên từ mảng ===
            $name = $productNames[array_rand($productNames)] . ' Mẫu ' . $i;
            // ========================================

            $price = rand(90000, 1000000); // Giá ngẫu nhiên từ 90k - 1 triệu
            
            // Chọn ngẫu nhiên category và type
            $category = collect([$cat1, $cat2, $cat3, $cat4, $cat5])->random();
            $type = collect([$type1, $type2, $type3, $type4, $type5])->random();

            $product = Product::create([
                'name' => $name,
                'slug' => Str::slug($name), // Bỏ '- $i' vì tên đã khá ngẫu nhiên
                'description' => 'Đây là mô tả chi tiết cho ' . $name . '. Sản phẩm có chất lượng tốt, mẫu mã đẹp.',
                'price' => $price,
                'stock' => rand(0, 100), // Tồn kho
                
                // === THÊM MỚI: Số lượng đã bán ===
                'sold_quantity' => rand(0, 500), 
                // ================================

                'main_image_url' => 'https://via.placeholder.com/300x300.png?text=Product+' . $i,
                'is_active' => true,
                'category_id' => $category->id,
                'gender' => $faker->randomElement(['male', 'female', 'unisex']),
                'product_type_id' => $type->id,
            ]);

            // === 3. GÁN QUAN HỆ MANY-TO-MANY (SIZE VÀ COLOR) ===
            
            // Gán 1-3 size ngẫu nhiên
            $randomSizeIds = collect($allSizeIds)->random(rand(1, 3))->toArray();
            $product->sizes()->attach($randomSizeIds);

            // Gán 1-2 màu ngẫu nhiên
            $randomColorIds = collect($allColorIds)->random(rand(1, 2))->toArray();
            $product->colors()->attach($randomColorIds);
        }

        $this->command->info('Sample product seeding complete!');
    }
}
