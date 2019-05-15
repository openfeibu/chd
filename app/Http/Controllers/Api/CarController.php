<?php

namespace App\Http\Controllers\Api;

use App\Repositories\Eloquent\PageRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController;
use App\Models\Brand;
use App\Models\BrandColor;
use App\Models\Car;
use App\Models\CarFinancialProduct;
use Log;

class CarController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getCars(Request $request)
    {
        $search_key = $request->input('search_key','');
        $min_price = $request->input('min_price','');
        $max_price = $request->input('max_price','');
        $order_by = $request->input('order_by','');
        $brand_id = $request->input('brand_id','');
        $category = $request->input('category','');
        $all_sub_ids = app(Brand::class)->getSubIds($brand_id);
        array_push($all_sub_ids,$brand_id);

        $brand_color_name = $request->input('brand_color_name','');
        $cars = Car::join('brands','brands.id','=','cars.type')
            ->select('brands.id as brand_id','brands.name as brand_name','brands.displaying as image','cars.id','cars.name','cars.price','cars.year','cars.selling_price','cars.category');
        if($brand_color_name)
        {
            $all_sub_ids = BrandColor::where('type',1)
                ->where('name',$brand_color_name)
                ->whereIn('brand_id',$all_sub_ids)
                ->pluck('brand_id');
            $cars = Car::join('brands','brands.id','=','cars.type')
                ->join('brand_colors','brand_colors.brand_id','=','brands.id')
                ->select('brands.id as brand_id','brands.name as brand_name','brand_colors.displaying as image','cars.id','cars.name','cars.price','cars.year','cars.selling_price','cars.category')
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
            ->when($search_key, function ($query) use ($search_key) {
                return $query->where(function ($query) use ($search_key) {
                    $query->where('cars.name','like','%'.$search_key.'%')->orWhere('brands.name','like','%'.$search_key.'%');
                });
            })
            ->when($category, function ($query) use ($category) {
                return $query->where(function ($query) use ($category) {
                    $query->whereRaw("find_in_set('".$category."',cars.category)");
                });
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
            $cars_data[$key]['financial'] = CarFinancialProduct::select('down','ratio','month_installment','periods')->where('car_id',$car['id'])->orderBy('id','asc')->first();
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
            ->select('brands.id as brand_id','brands.name as brand_name','brands.displaying as image','cars.id','cars.name','cars.price','cars.year','cars.configure','cars.selling_price','cars.commercial_insurance_price','cars.production_date','cars.emission_standard','cars.note','cars.category')
            ->where('cars.id',$id)
            ->first();

       // $car->name = $car->brand_name.' '.$car->name;
        $car->configure = array_values(json_decode($car->configure,true));
        $car->image = handle_image_url($car->image);
        $car->images = BrandColor::where('brand_id',$car->brand_id)->where('displaying','>','')->pluck('displaying');
        $car->total_price = $car->selling_price * 10000 + $car->commercial_insurance_price;
        $car = $car->toArray();

        $car['images'] = handle_images($car['images']);
        $car['financial'] = CarFinancialProduct::select('down','ratio','month_installment','periods')->where('car_id',$car['id'])->orderBy('id','asc')->get();

        return response()->json([
            'code' => '200',
            'data' => $car
        ]);
    }
    public function getRecommendCars(Request $request)
    {
        $limit = $request->input('limit',12);
        $cars = Car::join('brands','brands.id','=','cars.type')
            ->select('brands.id as brand_id','brands.name as brand_name','brands.displaying as image','cars.id','cars.name','cars.price','cars.year')
            ->where('is_recommend',1)
            ->orderBy('id','desc')
            ->limit($limit)
            ->get();
        $cars_data = $cars->toArray();
        foreach ($cars_data as $key => $car)
        {
            $cars_data[$key]['image'] = handle_image_url($car['image']);
        }
        return response()->json([
            'code' => '200',
            'data' => $cars_data
        ]);
    }
    public function getNewCars(Request $request)
    {
        $limit = $request->input('limit',5);
        $cars = Car::join('brands','brands.id','=','cars.type')
            ->select('brands.id as brand_id','brands.name as brand_name','brands.displaying as image','cars.id','cars.name','cars.price','cars.year')
            ->orderBy('id','desc')
            ->limit($limit)
            ->get();
        $cars_data = $cars->toArray();
        foreach ($cars_data as $key => $car)
        {
            $cars_data[$key]['image'] = handle_image_url($car['image']);
        }
        return response()->json([
            'code' => '200',
            'data' => $cars_data
        ]);
    }
}