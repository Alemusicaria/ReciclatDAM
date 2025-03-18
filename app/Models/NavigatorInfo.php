<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NavigatorInfo extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'app_code_name', 'app_name', 'app_version', 'cookie_enabled', 'hardware_concurrency', 
        'language', 'languages', 'max_touch_points', 'platform', 'product', 'product_sub', 
        'user_agent', 'vendor', 'vendor_sub', 'screen_width', 'screen_height', 
        'screen_avail_width', 'screen_avail_height', 'screen_color_depth', 'screen_pixel_depth'
    ];


}