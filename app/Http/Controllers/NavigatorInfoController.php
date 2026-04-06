<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NavigatorInfo;
use Exception;
use Illuminate\Support\Facades\Log;

class NavigatorInfoController extends Controller
{
    private function value(array $data, string $camel, string $snake, mixed $default = null): mixed
    {
        return $data[$camel] ?? $data[$snake] ?? $default;
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'appCodeName' => 'nullable|string|max:255',
                'app_code_name' => 'nullable|string|max:255',
                'appName' => 'nullable|string|max:255',
                'app_name' => 'nullable|string|max:255',
                'appVersion' => 'nullable|string|max:255',
                'app_version' => 'nullable|string|max:255',
                'cookieEnabled' => 'nullable|boolean',
                'cookie_enabled' => 'nullable|boolean',
                'hardwareConcurrency' => 'nullable|integer|min:0|max:1024',
                'hardware_concurrency' => 'nullable|integer|min:0|max:1024',
                'language' => 'nullable|string|max:50',
                'languages' => 'nullable|array',
                'maxTouchPoints' => 'nullable|integer|min:0|max:1024',
                'max_touch_points' => 'nullable|integer|min:0|max:1024',
                'platform' => 'nullable|string|max:255',
                'product' => 'nullable|string|max:255',
                'productSub' => 'nullable|string|max:255',
                'product_sub' => 'nullable|string|max:255',
                'userAgent' => 'nullable|string|max:2000',
                'user_agent' => 'nullable|string|max:2000',
                'vendor' => 'nullable|string|max:255',
                'vendorSub' => 'nullable|string|max:255',
                'vendor_sub' => 'nullable|string|max:255',
                'screenWidth' => 'nullable|integer|min:0|max:20000',
                'screen_width' => 'nullable|integer|min:0|max:20000',
                'screenHeight' => 'nullable|integer|min:0|max:20000',
                'screen_height' => 'nullable|integer|min:0|max:20000',
                'screenAvailWidth' => 'nullable|integer|min:0|max:20000',
                'screen_avail_width' => 'nullable|integer|min:0|max:20000',
                'screenAvailHeight' => 'nullable|integer|min:0|max:20000',
                'screen_avail_height' => 'nullable|integer|min:0|max:20000',
                'screenColorDepth' => 'nullable|integer|min:0|max:128',
                'screen_color_depth' => 'nullable|integer|min:0|max:128',
                'screenPixelDepth' => 'nullable|integer|min:0|max:128',
                'screen_pixel_depth' => 'nullable|integer|min:0|max:128',
            ]);

            NavigatorInfo::create([
                'app_code_name' => (string) $this->value($data, 'appCodeName', 'app_code_name', 'Unknown'),
                'app_name' => (string) $this->value($data, 'appName', 'app_name', 'Unknown'),
                'app_version' => (string) $this->value($data, 'appVersion', 'app_version', 'Unknown'),
                'cookie_enabled' => (bool) $this->value($data, 'cookieEnabled', 'cookie_enabled', false),
                'hardware_concurrency' => (int) $this->value($data, 'hardwareConcurrency', 'hardware_concurrency', 0),
                'language' => (string) $this->value($data, 'language', 'language', 'ca'),
                'languages' => json_encode((array) $this->value($data, 'languages', 'languages', [])),
                'max_touch_points' => (int) $this->value($data, 'maxTouchPoints', 'max_touch_points', 0),
                'platform' => (string) $this->value($data, 'platform', 'platform', 'Unknown'),
                'product' => (string) $this->value($data, 'product', 'product', 'Unknown'),
                'product_sub' => (string) $this->value($data, 'productSub', 'product_sub', ''),
                'user_agent' => (string) $this->value($data, 'userAgent', 'user_agent', $request->userAgent() ?: 'Unknown'),
                'vendor' => (string) $this->value($data, 'vendor', 'vendor', 'Unknown'),
                'vendor_sub' => (string) $this->value($data, 'vendorSub', 'vendor_sub', ''),
                'screen_width' => (int) $this->value($data, 'screenWidth', 'screen_width', 0),
                'screen_height' => (int) $this->value($data, 'screenHeight', 'screen_height', 0),
                'screen_avail_width' => (int) $this->value($data, 'screenAvailWidth', 'screen_avail_width', 0),
                'screen_avail_height' => (int) $this->value($data, 'screenAvailHeight', 'screen_avail_height', 0),
                'screen_color_depth' => (int) $this->value($data, 'screenColorDepth', 'screen_color_depth', 0),
                'screen_pixel_depth' => (int) $this->value($data, 'screenPixelDepth', 'screen_pixel_depth', 0),
            ]);

            return response()->json(['status' => 'success']);
        } catch (Exception $e) {
            Log::error('Error storing navigator info: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'No s\'ha pogut desar la informació del navegador.'], 500);
        }
    }
}