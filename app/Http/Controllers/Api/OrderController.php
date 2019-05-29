<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController;
use App\Models\User;
use App\Models\Banner;
use App\Models\Setting;
use App\Models\Car;
use App\Models\Order;
use App\Models\CarFinancialProduct;
use App\Models\FinancialProduct;
use App\Models\FinancialCategory;
use App\Models\OrderFinancial;
use App\Models\BrandColor;
use Log,Input;

class OrderController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth.api');
        $this->user = User::getUser();
    }
    public function getOrders(Request $request)
    {
        $type = $request->input('type','doing');
        $orders = Order::select('id','car_name','deposit','selling_price','car_financial_product_id','transfer_voucher_image','commercial_insurance_price','financial_product_name','is_financial','financial_category_id','financial_category_name','order_financial_id','status')->where('user_id',$this->user->id);
        if($type == 'doing')
        {
            $orders->whereIn('status',['unpaid_bank','un_financial_data']);
        }else{
            $orders->where('status','finish');
        }
        $orders = $orders->orderBy('id','desc')->paginate(20);


        return response()->json([
            'code' => '200',
            'total' => $orders->total(),
            'data' => $orders->toArray()['data'],
        ]);
    }
    public function getOrder(Request $request)
    {
        $order_id = $request->order_id;
        $order = Order::where('id',$order_id)->first();
        $order->car_image = handle_image_url($order->car_image);

        return response()->json([
            'code' => '200',
            'data' => $order,
        ]);
    }
    public function submitOrder(Request $request)
    {
        $attributes = $request->all();
        $attributes['user_id'] = $this->user->id;
        $car = Car::join('brands','brands.id','=','cars.type')->where('cars.id',$attributes['car_id'])->select('brands.name as brand_name','cars.*')->first();

        $attributes['car_name'] = $car['brand_name'].' '.$car['name'];
        $attributes['car_image'] = BrandColor::where('brand_id',$car->type)->where('displaying','>','')->value('displaying');

        $attributes['selling_price'] = $car['selling_price'];

        $attributes['deposit'] = $car['deposit'];

        if($attributes['car_financial_product_id'])
        {
            $car_financial_product = CarFinancialProduct::where('id',$attributes['car_financial_product_id'])->first();
            $financial_product = FinancialProduct::where('id',$car_financial_product['financial_product_id'])->first();
            $attributes['financial_product_name'] = $financial_product['name'];
            $attributes['down'] = $car_financial_product['down'];
            $attributes['ratio'] = $car_financial_product['ratio'];
            $attributes['month_installment'] = $car_financial_product['month_installment'];
            $attributes['periods'] = $car_financial_product['periods'];
            $attributes['is_financial'] = 1;
            $attributes['financial_category_id'] = $financial_product['category_id'];
            $attributes['financial_category_name'] = FinancialCategory::where('id',$financial_product['category_id'])->value('name') ;
            $attributes['commercial_insurance_price'] = $car['commercial_insurance_price'];
        }else{
            $attributes['commercial_insurance_price'] = $attributes['is_commercial_insurance'] ? $car['commercial_insurance_price'] : 0;
        }
        $order = Order::create($attributes);
        $order = Order::where('id',$order->id)->first();
        return response()->json([
            'code' => '200',
            'message' => '提交订单成功',
            'data' => $order,
        ]);

    }
    public function pay(Request $request)
    {
        $payment = $request->payment;
        $order_id = $request->order_id;
        if($payment == 'bank')
        {
            Order::where('id',$order_id)->update([
                'payment' => $payment,
                'status' => 'unpaid_bank',
            ]);
            return response()->json([
                'code' => '200',
                'message' => '提交成功',
            ]);
        }
        return response()->json([
            'code' => '400',
            'message' => '暂不支持该支付方式',
        ]);
    }
    public function uploadImage(Request $request)
    {
        $images_url = app('image_service')->uploadImages(Input::all(), 'order',0);

        return response()->json([
            'code' => '200',
            'data' => $images_url
        ],200);
    }
    public function submitTransferVoucher(Request $request)
    {
        $order_id = $request->order_id;
        $transfer_voucher_image = $request->transfer_voucher_image;
        $order = Order::where('id',$order_id)->first();
        Order::where('id',$order_id)->update([
            'transfer_voucher_image' => $transfer_voucher_image,
            'status' => $order->is_financial ? 'un_financial_data' : 'finish',
        ]);
        return response()->json([
            'code' => '200',
            'message' => '提交成功',
        ]);
    }
    public function submitOrderFinancial(Request $request)
    {
        $order_id = $request->order_id;
        $attributes = $request->all();
        $attributes['user_id'] = $this->user->id;
        $order = Order::where('id',$order_id)->first();
        if(!$order->is_financial)
        {
            return response()->json([
                'code' => '400',
                'message' => '该订单为全款购车，无需填写分期资料',
            ]);
        }
        $order_financial = OrderFinancial::where('order_id',$order_id)->first();
        if($order_financial)
        {
            unset($attributes['token']);
            OrderFinancial::where('order_id',$order_id)->update($attributes);
        }else{
            OrderFinancial::create($attributes);
            Order::where('id',$order_id)->update([
                'status' => 'finish',
            ]);
        }
        return response()->json([
            'code' => '200',
            'message' => '提交成功',
        ]);
    }

}
