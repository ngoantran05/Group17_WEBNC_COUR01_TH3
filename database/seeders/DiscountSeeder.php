<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Discount;
use Illuminate\Support\Facades\DB;

class DiscountSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Discount::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 1. Tạo mã GIAM10 (giảm 10%)
        Discount::create([
            'code' => 'GIAM10',
            'type' => 'percent',
            'value' => 10,
            'expires_at' => now()->addMonth(), // Hết hạn sau 1 tháng
            'usage_limit' => 100, // Tối đa 100 lượt
            'is_active' => true,
        ]);

        // 2. Tạo mã GIAM50K (giảm 50.000đ)
        Discount::create([
            'code' => 'GIAM50K',
            'type' => 'fixed',
            'value' => 50000,
            'expires_at' => null, // Không hết hạn
            'usage_limit' => null, // Không giới hạn
            'is_active' => true,
        ]);
    }
}