<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Discount;
use Illuminate\Support\Facades\DB;

class DiscountSeeder extends Seeder
{
    public function run(): void
    {
        // === BƯỚC 1: XÓA LỆNH TRUNCATE ===
        // DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        // Discount::truncate();
        // DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->command->info('Updating/Creating default discount codes...');

        // === BƯỚC 2: DÙNG updateOrCreate ===
        // Lệnh này: "Tìm code 'GIAM10', nếu không thấy thì tạo mới với các giá trị này"
        Discount::updateOrCreate(
            ['code' => 'GIAM10'], // Điều kiện tìm kiếm
            [                    // Dữ liệu sẽ tạo/cập nhật
                'type' => 'percent',
                'value' => 10,
                'expires_at' => now()->addMonth(), // Hết hạn sau 1 tháng (Sẽ cập nhật nếu chạy lại)
                'usage_limit' => 100,
                'is_active' => true,
            ]
        );

        Discount::updateOrCreate(
            ['code' => 'GIAM50K'], // Điều kiện tìm kiếm
            [                     // Dữ liệu sẽ tạo/cập nhật
                'type' => 'fixed',
                'value' => 50000,
                'expires_at' => null,
                'usage_limit' => null,
                'is_active' => true,
            ]
        );

        $this->command->info('Default discount codes checked/created.');
    }
}