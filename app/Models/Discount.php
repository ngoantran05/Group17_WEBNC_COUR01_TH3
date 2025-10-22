<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'type',
        'value',
        'expires_at',
        'usage_limit',
        'usage_count',
        'is_active',
    ];

    // Tự động chuyển đổi kiểu dữ liệu
    protected $casts = [
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    /**
     * Kiểm tra xem mã còn hợp lệ không
     */
    public function isValid()
    {
        // 1. Kiểm tra bật/tắt
        if (!$this->is_active) {
            return false;
        }

        // 2. Kiểm tra ngày hết hạn
        if ($this->expires_at && $this->expires_at->isPast()) {
            return false;
        }

        // 3. Kiểm tra lượt sử dụng
        if ($this->usage_limit !== null && $this->usage_count >= $this->usage_limit) {
            return false;
        }

        return true;
    }
}
