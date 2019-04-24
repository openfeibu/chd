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
        $brand_id = $request->input('brand_id','');
        $all_sub_ids = app(Brand::class)->getSubIds($brand_id);
        array_push($all_sub_ids,$brand_id);

        $brand_color_name = $request->input('brand_color_name','');
        if($brand_color_name)
        {
            $all_sub_ids = BrandColor::where('type',1)
                ->where('name',$brand_color_name)
                ->whereIn('brand_id',$all_sub_ids)
                ->pluck('brand_id');
        }

        $cars = Car::join('brands','brands.id','=','cars.type')
            ->select('brands.id as brand_id','brands.name as brand_name','brands.displaying as image','cars.*')
            ->when($all_sub_ids, function ($query) use ($all_sub_ids) {
                return $query->whereIn('type', $all_sub_ids);
            })->orderBy('id','desc')->paginate(20);

        $cars_data = $cars->toArray()['data'];
        foreach ($cars_data as $key => $car)
        {
            $cars_data[$key]['configure'] = json_decode($car['configure']);
            $cars_data[$key]['name'] = $car['brand_name'].' '.$car['name'];
            $cars_data[$key]['image'] = handle_image_url($car['image']);
        }
        return response()->json([
            'code' => '200',
            'total' => $cars->total(),
            'data' => $cars_data,
        ]);


    }
}