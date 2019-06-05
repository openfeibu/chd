<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\ResourceController as BaseController;
use App\Models\CarFinancialProduct;
use App\Models\FinancialProduct;
use App\Repositories\Eloquent\BrandRepositoryInterface;
use Auth;
use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\BrandColor;
use App\Models\Brand;
use App\Models\Order;
use App\Models\Provider;
use App\Models\Merchant;
use App\Models\OrderRecord;
use App\Repositories\Eloquent\CarRepositoryInterface;

class CarResourceController extends BaseController
{
    public function __construct(CarRepositoryInterface $car)
    {
        parent::__construct();
        $this->repository = $car;
        $this->repository
            ->pushCriteria(\App\Repositories\Criteria\RequestCriteria::class);
    }

    public function index(Request $request)
    {
        $limit = $request->input('limit',config('app.limit'));

        $search = $request->input('search',[]);
        $search_name = isset($search['search_name']) ? $search['search_name'] : '';

        if ($this->response->typeIs('json')) {
            $data = $this->repository;
            if(!empty($search_name))
            {
                $data = $data->where(function ($query) use ($search_name){
                    return $query->where('name','like','%'.$search_name.'%');
                });
            }
            $data = $data->setPresenter(\App\Repositories\Presenter\CarPresenter::class)
                ->orderBy('id','desc')
                ->getDataTable($limit);

            return $this->response
                ->success()
                ->count($data['recordsTotal'])
                ->data($data['data'])
                ->output();

        }
        return $this->response->title(trans('car.name'))
            ->view('car.index')
            ->output();

    }
    public function create(Request $request)
    {
        $car = $this->repository->newInstance([]);
        $brands = Brand::orderBy('id','asc')->get();
//        $brands = app(BrandRepositoryInterface::class)->getAllBrands();
//        var_dump($brands);exit;
        $instalment_financial_products = FinancialProduct::where('category_id',1)->get();
        $rent_financial_products = FinancialProduct::where('category_id',2)->get();

        return $this->response->title(trans('car.name'))
            ->view('car.create')
            ->data(compact('car','brands','instalment_financial_products','rent_financial_products'))
            ->output();
    }
    public function store(Request $request)
    {
        try {
            $attributes = $request->all();
            $attributes['category'] = $attributes['category'] ? implode(',', $attributes['category']) : '';

            $car = $this->repository->create([
                'name' => isset($attributes['name']) ? $attributes['name'] : '',
                'year' => isset($attributes['year']) ? $attributes['year'] : '',
                'type' => isset($attributes['type']) ? $attributes['type'] : '',
                'price' => isset($attributes['price']) ? $attributes['price'] : '',
                'configure' => isset($attributes['configure']) ? $attributes['configure'] : '',
                'selling_price' => isset($attributes['selling_price']) ? $attributes['selling_price'] : '',
                'commercial_insurance_price' => isset($attributes['commercial_insurance_price']) ? $attributes['commercial_insurance_price'] : '',
                'production_date' => isset($attributes['production_date']) ? $attributes['production_date'] : '',
                'emission_standard' => isset($attributes['emission_standard']) ? $attributes['emission_standard'] : '',
                'note' => isset($attributes['note']) ? $attributes['note'] : '',
                'image' => isset($attributes['image']) ? $attributes['image'] : '',
                'category' => isset($attributes['category']) ? $attributes['category'] : '',
                'recommend_type' => isset($attributes['recommend_type']) ? $attributes['recommend_type'] : ''
            ]);

            if(strpos($attributes['category'],'instalment') !==false)
            {
                $instalment_financial_product_ids = $attributes['instalment_financial_product_id'];

                foreach ($instalment_financial_product_ids as $key =>  $instalment_financial_product_id)
                {
                    if(!empty($attributes['instalment_financial_product_down'][$key]))
                    {
                        CarFinancialProduct::create([
                            'car_id' => $car->id,
                            'financial_product_id' => $instalment_financial_product_id,
                            'down' => $attributes['instalment_financial_product_down'][$key],
                            'ratio' => $attributes['instalment_financial_product_ratio'][$key],
                            'month_installment' => $attributes['instalment_financial_product_month_installment'][$key],
                            'periods' => $attributes['instalment_financial_product_periods'][$key],
                        ]);
                    }
                }
            }else if(strpos($attributes['category'],'rent') !==false){
                $rent_financial_product_ids = $attributes['rent_financial_product_id'];

                foreach ($rent_financial_product_ids as $key =>  $rent_financial_product_id)
                {
                    if(!empty($attributes['rent_financial_product_down'][$key]))
                    {
                        CarFinancialProduct::create([
                            'car_id' => $car->id,
                            'financial_product_id' => $rent_financial_product_id,
                            'down' => $attributes['rent_financial_product_down'][$key],
                            'ratio' => $attributes['rent_financial_product_ratio'][$key],
                            'month_installment' => $attributes['rent_financial_product_month_installment'][$key],
                            'periods' => $attributes['instalment_financial_product_periods'][$key],
                        ]);
                    }
                }
            }

            return $this->response->message(trans('messages.success.created', ['Module' => trans('car.name')]))
                ->code(0)
                ->status('success')
                ->url(guard_url('car'))
                ->redirect();
        } catch (Exception $e) {
            return $this->response->message($e->getMessage())
                ->code(400)
                ->status('error')
                ->url(guard_url('car'))
                ->redirect();
        }
    }
    public function show(Request $request,Car $car)
    {
        if ($car->exists) {
            $view = 'car.show';
        } else {
            $view = 'car.create';
        }
        $brands = Brand::orderBy('id','asc')->get();

        $instalment_financial_products = FinancialProduct::where('category_id',1)->get();
        foreach ($instalment_financial_products as $key => $instalment_financial_product)
        {
            $car_instalment_financial_product = CarFinancialProduct::where('car_id',$car->id)->where('financial_product_id',$instalment_financial_product->id)->first();

            if($car_instalment_financial_product)
            {
                $instalment_financial_products[$key]['down'] = $car_instalment_financial_product->down;
                $instalment_financial_products[$key]['ratio'] = $car_instalment_financial_product->ratio;
                $instalment_financial_products[$key]['month_installment'] = $car_instalment_financial_product->month_installment;
                $instalment_financial_products[$key]['periods'] = $car_instalment_financial_product->periods;
            }else{
                $instalment_financial_products[$key]['down'] = '';
                $instalment_financial_products[$key]['ratio'] = '98';
                $instalment_financial_products[$key]['month_installment'] = '';
                $instalment_financial_products[$key]['periods'] = '';
            }
        }

        $rent_financial_products = FinancialProduct::where('category_id',2)->get();
        foreach ($rent_financial_products as $key => $rent_financial_product)
        {
            $car_rent_financial_product = CarFinancialProduct::where('car_id',$car->id)->where('financial_product_id',$instalment_financial_product->id)->first();
            if($car_rent_financial_product)
            {
                $rent_financial_products[$key]['down'] = $car_rent_financial_product->down;
                $rent_financial_products[$key]['ratio'] = $car_rent_financial_product->ratio;
                $rent_financial_products[$key]['month_installment'] = $car_rent_financial_product->month_installment;
                $rent_financial_products[$key]['periods'] = $car_rent_financial_product->periods;
            }else{
                $rent_financial_products[$key]['down'] = '';
                $rent_financial_products[$key]['ratio'] = '98';
                $rent_financial_products[$key]['month_installment'] = '';
                $rent_financial_products[$key]['periods'] = '';
            }
        }

        return $this->response->title(trans('app.view') . ' ' . trans('car.name'))
            ->data(compact('car','brands','instalment_financial_products','rent_financial_products'))
            ->view($view)
            ->output();
    }
    public function update(Request $request,Car $car)
    {
        try {
            $attributes = $request->all();
            $attributes['category'] = $attributes['category'] ? implode(',', $attributes['category']) : '';
            CarFinancialProduct::where('car_id',$car->id)->delete();
            $car->update([
                'name' => isset($attributes['name']) ? $attributes['name'] : '',
                'year' => isset($attributes['year']) ? $attributes['year'] : '',
                'type' => isset($attributes['type']) ? $attributes['type'] : '',
                'price' => isset($attributes['price']) ? $attributes['price'] : '',
                'content' => isset($attributes['content']) ? $attributes['content'] : '',
                'configure' => isset($attributes['configure']) ? $attributes['configure'] : '',
                'selling_price' => isset($attributes['selling_price']) ? $attributes['selling_price'] : '',
                'commercial_insurance_price' => isset($attributes['commercial_insurance_price']) ? $attributes['commercial_insurance_price'] : '',
                'production_date' => isset($attributes['production_date']) ? $attributes['production_date'] : '',
                'emission_standard' => isset($attributes['emission_standard']) ? $attributes['emission_standard'] : '',
                'note' => isset($attributes['note']) ? $attributes['note'] : '',
                'image' => isset($attributes['image']) ? $attributes['image'] : '',
                'category' => isset($attributes['category']) ? $attributes['category'] : '',
                'recommend_type' => isset($attributes['recommend_type']) ? $attributes['recommend_type'] : ''
            ]);

            if(strpos($attributes['category'],'instalment') !==false)
            {
                $instalment_financial_product_ids = $attributes['instalment_financial_product_id'];

                foreach ($instalment_financial_product_ids as $key =>  $instalment_financial_product_id)
                {
                    if(!empty($attributes['instalment_financial_product_down'][$key]))
                    {
                        CarFinancialProduct::create([
                            'car_id' => $car->id,
                            'financial_product_id' => $instalment_financial_product_id,
                            'down' => $attributes['instalment_financial_product_down'][$key],
                            'ratio' => $attributes['instalment_financial_product_ratio'][$key],
                            'month_installment' => $attributes['instalment_financial_product_month_installment'][$key],
                            'periods' => $attributes['instalment_financial_product_periods'][$key],
                        ]);
                    }
                }
            }else if(strpos($attributes['category'],'rent') !==false){
                $rent_financial_product_ids = $attributes['rent_financial_product_id'];

                foreach ($rent_financial_product_ids as $key =>  $rent_financial_product_id)
                {
                    if(!empty($attributes['rent_financial_product_down'][$key]))
                    {
                        CarFinancialProduct::create([
                            'car_id' => $car->id,
                            'financial_product_id' => $rent_financial_product_id,
                            'down' => $attributes['rent_financial_product_down'][$key],
                            'ratio' => $attributes['rent_financial_product_ratio'][$key],
                            'month_installment' => $attributes['rent_financial_product_month_installment'][$key],
                            'periods' => $attributes['instalment_financial_product_periods'][$key],
                        ]);
                    }
                }
            }

            return $this->response->message(trans('messages.success.updated', ['Module' => trans('car.name')]))
                ->code(0)
                ->status('success')
                ->url(guard_url('car/' . $car->id))
                ->redirect();
        } catch (Exception $e) {
            return $this->response->message($e->getMessage())
                ->code(400)
                ->status('error')
                ->url(guard_url('car/' . $car->id))
                ->redirect();
        }
    }
    public function destroy(Request $request,Car $car)
    {
        try {
            $this->repository->forceDelete([$car->id]);

            return $this->response->message(trans('messages.success.deleted', ['Module' => trans('car.name')]))
                ->status("success")
                ->code(202)
                ->url(guard_url('car'))
                ->redirect();

        } catch (Exception $e) {

            return $this->response->message($e->getMessage())
                ->status("error")
                ->code(400)
                ->url(guard_url('car'))
                ->redirect();
        }
    }
    public function destroyAll(Request $request)
    {
        try {
            $data = $request->all();
            $ids = $data['ids'];
            $this->repository->forceDelete($ids);

            return $this->response->message(trans('messages.success.deleted', ['Module' => trans('car.name')]))
                ->status("success")
                ->code(202)
                ->url(guard_url('car'))
                ->redirect();

        } catch (Exception $e) {
            return $this->response->message($e->getMessage())
                ->status("error")
                ->code(400)
                ->url(guard_url('car'))
                ->redirect();
        }
    }
}
