<?php

namespace App\Repositories\Presenter;

use League\Fractal\TransformerAbstract;
use App\Models\Order;

class OrderTransformer extends TransformerAbstract
{
    public function transform(\App\Models\Order $order)
    {
        return [
            'id' => $order->id,
            'user_id' => $order->user_id,
            'nickname' => $order->user->nickname ,
            'car_name' => $order->car_name,
            'color' => $order->color,
            'company' =>  $order->company,
            'linkman' => $order->linkman,
            'phone' => $order->phone ,
            'city' => $order->city,
            'commercial_insurance_price' => $order->commercial_insurance_price ,
            'is_commercial_insurance' => $order->is_commercial_insurance,
            'selling_price' => $order->selling_price,
            'car_financial_product_id' => $order->car_financial_product_id,
            'total_price' => $order->total_price,
            'status' => $order->status,
            'status_desc' => $order->status_desc,
            'payment' => $order->payment,
            'payment_desc' => $order->payment_desc,
            'buy_type' =>  $order->buy_type,
            'created_at' => $order->created_at->format('Y-m-d H:i:s') ,
        ];
    }
}
