<?php

namespace App\Http\Controllers\Api;

use App\Models\CarFinancialProduct;
use App\Models\FinancialProduct;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController;
use App\Models\Banner;
use App\Models\Setting;
use Log;

class HomeController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getBanners()
    {
        $banners = Banner::orderBy('order','asc')->orderBy('id','asc')->get();
        foreach ($banners as $key => $banner)
        {
            $banner->image = url('image/original/'.$banner->image);
        }
        return response()->json([
            'code' => '200',
            'data' => $banners,
        ]);

    }
    public function getBank(Request $request)
    {
        $data = [
            'bank' => setting('bank'),
            'bank_name' => setting('bank_name'),
            'bank_account' => setting('bank_account'),
        ];
        return response()->json([
            'code' => '200',
            'data' => $data,
        ]);
    }
    public function getAuthFile(Request $request)
    {
        $order_id = $request->order_id;

        $car_financial_product_id = Order::where('id',$order_id)->value('car_financial_product_id');

        $car_financial_product = CarFinancialProduct::where('id',$car_financial_product_id)->first();

        $financial_product = FinancialProduct::where('id',$car_financial_product->financial_product_id)->first();

        $auth_files = explode(',',$financial_product->auth_file);
        $data = [];
        $i=1;
        foreach ($auth_files as $key => $auth_file)
        {
            $data[] =[
                'name' =>  $financial_product->auth_file_name.'模板'.$i,
                'image' => url('image/original'.$auth_file)
            ];
            $i++;
        }

        return response()->json([
            'code' => '200',
            'data' => $data,
        ]);
    }
    public function getWechatCheck(Request $request)
    {
        return response()->json([
            'code' => '200',
            'data' => setting('wechat_check'),
        ]);
    }
    public function getInsuranceRebateText(Request $request)
    {
        return response()->json([
            'code' => '200',
            'data' => setting('insurance_rebate_text'),
        ]);
    }
    public function getPage(Request $request)
    {
        $slug = $request->input('slug','about_rent');
        return response()->json([
            'code' => '200',
            'data' => [
                'title' => page($slug,'title'),
                'content' => page($slug,'content')
            ],
        ]);
    }
}
