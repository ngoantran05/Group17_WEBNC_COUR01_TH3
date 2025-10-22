<?php
namespace Database\Seeders;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categoryIds = Category::pluck('id')->toArray();
        if (empty($categoryIds)) {
            $this->command->info('Không tìm thấy danh mục nào. Hãy chạy CategorySeeder trước.');
            return;
        }

        $products = [
            ['name' => 'Áo Sơ Mi Trắng', 'price' => 350000],
            ['name' => 'Áo Thun Polo', 'price' => 250000],
            ['name' => 'Quần Jean Rách Gối', 'price' => 500000],
            ['name' => 'Quần Kaki Ống Đứng', 'price' => 400000],
            ['name' => 'Váy Hoa Nhí', 'price' => 450000],
        ];

        foreach ($products as $product) {
            Product::create([
                'name' => $product['name'],
                'slug' => Str::slug($product['name']), 
                'price' => $product['price'],
                'description' => 'Đây là mô tả mẫu cho sản phẩm ' . $product['name'],
                'category_id' => $categoryIds[array_rand($categoryIds)], 
                'status' => 'available',
            ]);
        }
    }
}
