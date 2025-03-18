<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NavigatorInfo;
use Exception;
use Log;

class NavigatorInfoController extends Controller
{
    public function store(Request $request)
    {
        try {
            $data = $request->all();

            Log::info('Received data: ', $data);

            NavigatorInfo::create([
                'app_code_name' => $data['appCodeName'],
                'app_name' => $data['appName'],
                'app_version' => $data['appVersion'],
                'cookie_enabled' => $data['cookieEnabled'],
                'hardware_concurrency' => $data['hardwareConcurrency'],
                'language' => $data['language'],
                'languages' => json_encode($data['languages']),
                'max_touch_points' => $data['maxTouchPoints'],
                'platform' => $data['platform'],
                'product' => $data['product'],
                'product_sub' => $data['productSub'],
                'user_agent' => $data['userAgent'],
                'vendor' => $data['vendor'],
                'vendor_sub' => $data['vendorSub'],
                'screen_width' => $data['screenWidth'],
                'screen_height' => $data['screenHeight'],
                'screen_avail_width' => $data['screenAvailWidth'],
                'screen_avail_height' => $data['screenAvailHeight'],
                'screen_color_depth' => $data['screenColorDepth'],
                'screen_pixel_depth' => $data['screenPixelDepth'],
            ]);

            return response()->json(['status' => 'success']);
        } catch (Exception $e) {
            Log::error('Error storing navigator info: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
}