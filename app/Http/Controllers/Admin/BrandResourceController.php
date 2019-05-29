<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\ResourceController as BaseController;
use Auth;
use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\BrandColor;
use App\Models\Brand;
use App\Models\Order;
use App\Models\Provider;
use App\Models\Merchant;
use App\Models\OrderRecord;
use App\Repositories\Eloquent\BrandRepositoryInterface;

class BrandResourceController extends BaseController
{
    public function __construct(BrandRepositoryInterface $brand)
    {
        parent::__construct();
        $this->repository = $brand;
        $this->repository
            ->pushCriteria(\App\Repositories\Criteria\RequestCriteria::class);
    }

    public function index(Request $request)
    {
        $limit = $request->input('limit',config('app.limit'));

        if ($this->response->typeIs('json')) {
            $data = $this->repository
                ->setPresenter(\App\Repositories\Presenter\BrandPresenter::class)
                ->orderBy('id','desc')
                ->getDataTable($limit);

            return $this->response
                ->success()
                ->count($data['recordsTotal'])
                ->data($data['data'])
                ->output();

        }
        return $this->response->title(trans('app.car.name'))
            ->view('car.index')
            ->output();

    }
    public function create(Request $request)
    {
        $brand = $this->repository->newInstance([]);

        return $this->response->title(trans('app.car.name'))
            ->view('car.create')
            ->data(compact('car'))
            ->output();
    }
    public function store(Request $request)
    {
        try {
            $attributes = $request->all();
            $attributes['payment_company_id'] = Auth::user()->payment_company_id;
            $brand = $this->repository->create($attributes);

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
    public function show(Request $request,Brand $brand)
    {
        if ($brand->exists) {
            $view = 'car.show';
        } else {
            $view = 'car.create';
        }

        return $this->response->title(trans('app.view') . ' ' . trans('car.name'))
            ->data(compact('car'))
            ->view($view)
            ->output();
    }
    public function update(Request $request,Brand $brand)
    {
        try {
            $attributes = $request->all();

            $brand->update($attributes);

            return $this->response->message(trans('messages.success.updated', ['Module' => trans('car.name')]))
                ->code(0)
                ->status('success')
                ->url(guard_url('car/' . $brand->id))
                ->redirect();
        } catch (Exception $e) {
            return $this->response->message($e->getMessage())
                ->code(400)
                ->status('error')
                ->url(guard_url('car/' . $brand->id))
                ->redirect();
        }
    }
    public function destroy(Request $request,Brand $brand)
    {
        try {
            $this->repository->forceDelete([$brand->id]);

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
