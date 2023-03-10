<?php

namespace App\Http\Controllers\Api;

use App\Models\CarColor;
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
            ->select('brands.id as brand_id','brands.name as brand_name','brands.displaying','cars.id','cars.name','cars.price','cars.year','cars.image','cars.selling_price','cars.category');
        if($brand_color_name)
        {
            $color_brand_ids = BrandColor::where('type',1)
                ->where('name',$brand_color_name)
                ->whereIn('brand_id',$all_sub_ids)
                ->pluck('brand_id');
            $cars = Car::join('brands','brands.id','=','cars.type')
                ->leftjoin('brand_colors','brand_colors.brand_id','=','brands.id')
                ->leftjoin('car_colors','car_colors.car_id','=','cars.id')
                ->select('brands.id as brand_id','brands.name as brand_name','brand_colors.displaying as image','cars.id','cars.name','cars.price','cars.year','cars.selling_price','cars.category')
                ->where(function($query) use ($color_brand_ids,$brand_color_name){
                    return $query->where(function($query) use ($color_brand_ids){
                        $query->whereIn('cars.type', $color_brand_ids);
                    })->orWhere(function($query) use ($brand_color_name){
                        $query->where('car_colors.name', $brand_color_name);
                    });
                });
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
            $cars_data[$key]['images'] = explode(',',$car['image']);
            $cars_data[$key]['images'] = array_filter($cars_data[$key]['images']);
            if($cars_data[$key]['images'])
            {
                $cars_data[$key]['image'] = $cars_data[$key]['images'][0];
            }else{
                $cars_data[$key]['image'] = isset($car['displaying']) ? $car['displaying'] : '';
            }

            $cars_data[$key]['image'] = handle_image_url($cars_data[$key]['image']);
            $cars_data[$key]['financial'] = CarFinancialProduct::getCarFirstFinancial($car['id']);
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
            ->select('brands.id as brand_id','brands.name as brand_name','brands.displaying','cars.id','cars.name','cars.price','cars.year','cars.image','cars.configure','cars.selling_price','cars.commercial_insurance_price','cars.production_date','cars.emission_standard','cars.note','cars.content','cars.category')
            ->where('cars.id',$id)
            ->first();

       // $car->name = $car->brand_name.' '.$car->name;
        $car->configure = $car->configure ? array_values(json_decode($car->configure,true)) : [];
        $car->images =  explode(',',$car->image);
        $car->images = array_filter($car->images);
        if($car->images)
        {
            $car->image = $car->images[0];
        }else{
            $car->image = $car->displaying;
        }
        $car->image = handle_image_url($car->image);
        $car->images = $car->images ?? BrandColor::where('brand_id',$car->brand_id)->where('displaying','>','')->pluck('displaying');
        $car->total_price = $car->selling_price * 10000 + $car->commercial_insurance_price;
        $car = $car->toArray();

        $car['images'] = handle_images($car['images']);
        $car['financial'] = CarFinancialProduct::getCarFirstFinancials($car['id']);

        $car['insurance_rebate_text']= setting('insurance_rebate_text');
        return response()->json([
            'code' => '200',
            'data' => $car
        ]);
    }
    public function getRecommendCars(Request $request)
    {
        $limit = $request->input('limit',12);
        $cars = Car::join('brands','brands.id','=','cars.type')
            ->select('brands.id as brand_id','brands.name as brand_name','brands.displaying','cars.id','cars.name','cars.price','cars.image','cars.selling_price','cars.year','cars.category')
            ->whereRaw("find_in_set('hot',recommend_type)")
            ->orderBy('id','desc')
            ->limit($limit)
            ->get();
        $cars_data = $cars->toArray();
        foreach ($cars_data as $key => $car)
        {
            $cars_data[$key]['images'] = explode(',',$car['image']);
            $cars_data[$key]['images'] = array_filter($cars_data[$key]['images']);
            if($cars_data[$key]['images'])
            {
                $cars_data[$key]['image'] = $cars_data[$key]['images'][0];
            }else{
                $cars_data[$key]['image'] = isset($car['displaying']) ? $car['displaying'] : '';
            }
            $cars_data[$key]['image'] = handle_image_url($cars_data[$key]['image']);
            $cars_data[$key]['financial'] = CarFinancialProduct::getCarFirstFinancial($car['id']);
        }
        return response()->json([
            'code' => '200',
            'data' => $cars_data
        ]);
    }
    public function getNewCars(Request $request)
    {
        $cars = Car::join('brands','brands.id','=','cars.type')
            ->select('brands.id as brand_id','brands.name as brand_name','brands.displaying','cars.id','cars.name','cars.price','cars.selling_price','cars.image','cars.year','cars.category')
            ->whereRaw("find_in_set('new',recommend_type)")
            ->orderBy('id','desc')
            ->limit(5)
            ->get();
        $cars_data = $cars->toArray();
        foreach ($cars_data as $key => $car)
        {
            $cars_data[$key]['images'] = explode(',',$car['image']);
            $cars_data[$key]['images'] = array_filter($cars_data[$key]['images']);
            if($cars_data[$key]['images'])
            {
                $cars_data[$key]['image'] = $cars_data[$key]['images'][0];
            }else{
                $cars_data[$key]['image'] = isset($car['displaying']) ? $car['displaying'] : '';
            }
            $cars_data[$key]['image'] = handle_image_url($cars_data[$key]['image']);
            $cars_data[$key]['financial'] = CarFinancialProduct::getCarFirstFinancial($car['id']);
        }
        return response()->json([
            'code' => '200',
            'data' => $cars_data
        ]);
    }
    public function getRecommendRentCars(Request $request)
    {
        $limit = $request->input('limit',3);
        $cars = Car::join('brands','brands.id','=','cars.type')
            ->select('brands.id as brand_id','brands.name as brand_name','brands.displaying','cars.id','cars.name','cars.price','cars.image','cars.selling_price','cars.year','cars.category')
            ->whereRaw("find_in_set('rent',recommend_type)")
            ->whereRaw("find_in_set('rent',category)")
            ->orderBy('id','desc')
            ->limit($limit)
            ->get();
        $cars_data = $cars->toArray();
        foreach ($cars_data as $key => $car)
        {
            $cars_data[$key]['images'] = explode(',',$car['image']);
            $cars_data[$key]['images'] = array_filter($cars_data[$key]['images']);
            if($cars_data[$key]['images'])
            {
                $cars_data[$key]['image'] = $cars_data[$key]['images'][0];
            }else{
                $cars_data[$key]['image'] = isset($car['displaying']) ? $car['displaying'] : '';
            }

            $cars_data[$key]['image'] = handle_image_url($cars_data[$key]['image']);
            $cars_data[$key]['financial'] = CarFinancialProduct::getCarFirstFinancial($car['id']);
        }
        return response()->json([
            'code' => '200',
            'data' => $cars_data
        ]);

    }
    public function getCarColors(Request $request)
    {
        $car_id = $request->car_id;
        $car = Car::where('id',$car_id)->first();
        $brand_id = $car->type;
        $car_shape_colors = CarColor::where('car_id',$car->id)->where('type',1)->groupBy('name')->orderBy('id','desc')->select('name')->get()->toArray();
        $car_interior_colors = CarColor::where('car_id',$car->id)->where('type',2)->groupBy('name')->orderBy('id','desc')->select('name')->get()->toArray();
        $all_colors = [];
        if(count($car_shape_colors))
        {
            $shape_colors = $car_shape_colors;
            $interior_colors = $car_interior_colors;

        }else{
            $all_sub_ids = app(Brand::class)->getSubIds($brand_id);
            array_push($all_sub_ids,$brand_id);

            $shape_colors = BrandColor::select('id','brand_id','name','displaying')->where('type',1)->whereIn('brand_id',$all_sub_ids)->groupBy('name')->select('name')->get()->toArray();

            $interior_colors = BrandColor::select('id','brand_id','name','displaying')->where('type',2)->whereIn('brand_id',$all_sub_ids)->groupBy('name')->select('name')->get()->toArray();
        }

        foreach ($shape_colors as $key => $shape_color)
        {
            foreach ($interior_colors as $key => $interior_color)
            {
                $all_colors[] = [
                    'name' => $shape_color['name'] . '/' . $interior_color['name'],
                ];
            }
        }
        return response()->json([
            'code' => '200',
            'data' => $all_colors,
        ]);
    }

}