<?php

namespace App\Http\Controllers\Api;

use App\Repositories\Eloquent\PageRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController;
use App\Models\Brand;
use App\Models\BrandColor;
use Log;

class BrandController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getBrands()
    {
        $brands = Brand::where('parent_id','0')->orderBy('letter','asc')->orderBy('id','asc')->get();

        $brands = handle_array_images($brands,'logo');
        return response()->json([
            'code' => '200',
            'data' => $brands,
        ]);
    }
    public function getBrandColors(Request $request)
    {
        $brand_id = $request->input('brand_id');

        $all_sub_ids = app(Brand::class)->getSubIds($brand_id);
        array_push($all_sub_ids,$brand_id);

        $type = 1;
        $brand_colors = BrandColor::select('id','brand_id','name','displaying')->where('type',$type)->whereIn('brand_id',$all_sub_ids)->groupBy('name')->get();

        $brand_colors = handle_array_images($brand_colors,'displaying');
        return response()->json([
            'code' => '200',
            'data' => $brand_colors,
        ]);
    }
}
