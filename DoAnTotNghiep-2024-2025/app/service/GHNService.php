// file app/Services/GHNService.php
<?php
namespace App\Services;
use Illuminate\Support\Facades\Http;

class GHNService
{
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('ghn.api_key'); // Lấy API key từ cấu hình
        $this->baseUrl = config('ghn.base_url'); // Lấy base URL từ cấu hình
    }

    // Lấy chi tiết đơn hàng từ mã vận chuyển
    public function getOrderDetail($orderCode)
    {
        $url = $this->baseUrl . 'v2/shipping-order/detail'; // Endpoint để lấy thông tin chi tiết
        $response = Http::withHeaders([
            'Token' => $this->apiKey, // Thêm header với API key
        ])->post($url, [
            'order_code' => $orderCode, // Truyền mã vận chuyển vào API
        ]);

        if ($response->successful()) {
            return $response->json(); // Trả về kết quả nếu thành công
        }

        throw new \Exception('Lỗi khi gọi API GHN: ' . $response->body()); // Xử lý lỗi nếu có
    }
}
