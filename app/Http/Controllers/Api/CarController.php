<?php

namespace App\Http\Controllers\Api;

use App\Repositories\Eloquent\PageRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController;
use App\Models\Brand;
use App\Models\BrandColor;
use App\Models\Car;
use Log;

class CarController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getCars(Request $request)
    {
        $min_price = $request->input('min_price','');
        $max_price = $request->input('max_price','');
        $order_by = $request->input('order_by','');
        $brand_id = $request->input('brand_id','');
        $all_sub_ids = app(Brand::class)->getSubIds($brand_id);
        array_push($all_sub_ids,$brand_id);

        $brand_color_name = $request->input('brand_color_name','');
        $cars = Car::join('brands','brands.id','=','cars.type')
            ->select('brands.id as brand_id','brands.name as brand_name','brands.displaying as image','cars.id','cars.name','cars.price','cars.year');
        if($brand_color_name)
        {
            $all_sub_ids = BrandColor::where('type',1)
                ->where('name',$brand_color_name)
                ->whereIn('brand_id',$all_sub_ids)
                ->pluck('brand_id');
            $cars = Car::join('brands','brands.id','=','cars.type')
                ->join('brand_colors','brand_colors.brand_id','=','brands.id')
                ->select('brands.id as brand_id','brands.name as brand_name','brand_colors.displaying as image','cars.id','cars.name','cars.price','cars.year')
                ->where('brand_colors.name',$brand_color_name);
        }


        $cars = $cars->when($all_sub_ids, function ($query) use ($all_sub_ids) {
                return $query->whereIn('cars.type', $all_sub_ids);
            })
            ->when($min_price, function ($query) use ($min_price) {
                return $query->where('cars.price','>=', $min_price);
            })
            ->when($max_price, function ($query) use ($max_price) {
                return $query->where('cars.price','<=', $max_price);
            })
            ->when($order_by, function ($query) use ($order_by) {
                $order_by_arr = explode('-',$order_by);
                return $query->orderBy('cars.'.$order_by_arr[0],$order_by_arr[1]);
            })
            ->orderBy('id','desc')
            ->paginate(20);

        $cars_data = $cars->toArray()['data'];
        foreach ($cars_data as $key => $car)
        {
            //$cars_data[$key]['configure'] = json_decode($car['configure']);
            //$cars_data[$key]['name'] = $car['brand_name'].' '.$car['name'];
            $cars_data[$key]['image'] = handle_image_url($car['image']);
        }
        return response()->json([
            'code' => '200',
            'total' => $cars->total(),
            'data' => $cars_data,
        ]);


    }
    public function getCar(Request $request, $id)
    {
        $car = Car::join('brands','brands.id','=','cars.type')
            ->select('brands.id as brand_id','brands.name as brand_name','brands.displaying as image','cars.id','cars.name','cars.price','cars.year','cars.configure')
            ->where('cars.id',$id)
            ->first();

       // $car->name = $car->brand_name.' '.$car->name;
        $car->configure = json_decode($car->configure);
        $car->image = handle_image_url($car->image);
        $car->images = BrandColor::where('brand_id',$car->brand_id)->whereNotNull('displaying')->pluck('displaying');
        $car = $car->toArray();

        $car['images'] = handle_images($car['images']);

        return response()->json([
            'code' => '200',
            'data' => $car
        ]);
    }
}