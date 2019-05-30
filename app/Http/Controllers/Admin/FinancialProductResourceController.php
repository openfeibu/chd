<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\ResourceController as BaseController;
use Auth;
use Illuminate\Http\Request;
use App\Models\FinancialProduct;
use App\Models\BrandColor;
use App\Models\Brand;
use App\Models\Order;
use App\Models\Provider;
use App\Models\Merchant;
use App\Models\OrderRecord;
use App\Repositories\Eloquent\FinancialProductRepositoryInterface;

class FinancialProductResourceController extends BaseController
{
    public function __construct(FinancialProductRepositoryInterface $financial_product)
    {
        parent::__construct();
        $this->repository = $financial_product;
        $this->repository
            ->pushCriteria(\App\Repositories\Criteria\RequestCriteria::class);
    }

    public function index(Request $request)
    {
        $limit = $request->input('limit',config('app.limit'));

        if ($this->response->typeIs('json')) {
            $data = $this->repository
                ->setPresenter(\App\Repositories\Presenter\FinancialProductPresenter::class)
                ->orderBy('id','asc')
                ->getDataTable($limit);

            return $this->response
                ->success()
                ->count($data['recordsTotal'])
                ->data($data['data'])
                ->output();

        }
        return $this->response->title(trans('financial_product.name'))
            ->view('financial_product.index')
            ->output();

    }
    public function create(Request $request)
    {
        $financial_product = $this->repository->newInstance([]);

        return $this->response->title(trans('financial_product.name'))
            ->view('financial_product.create')
            ->data(compact('financial_product'))
            ->output();
    }
    public function store(Request $request)
    {
        try {
            $attributes = $request->all();

            $financial_product = $this->repository->create($attributes);

            return $this->response->message(trans('messages.success.created', ['Module' => trans('financial_product.name')]))
                ->code(0)
                ->status('success')
                ->url(guard_url('financial_product'))
                ->redirect();
        } catch (Exception $e) {
            return $this->response->message($e->getMessage())
                ->code(400)
                ->status('error')
                ->url(guard_url('financial_product'))
                ->redirect();
        }
    }
    public function show(Request $request,FinancialProduct $financial_product)
    {
        if ($financial_product->exists) {
            $view = 'financial_product.show';
        } else {
            $view = 'financial_product.create';
        }

        return $this->response->title(trans('app.view') . ' ' . trans('financial_product.name'))
            ->data(compact('financial_product'))
            ->view($view)
            ->output();
    }
    public function update(Request $request,FinancialProduct $financial_product)
    {
        try {
            $attributes = $request->all();

            $financial_product->update($attributes);

            return $this->response->message(trans('messages.success.updated', ['Module' => trans('financial_product.name')]))
                ->code(0)
                ->status('success')
                ->url(guard_url('financial_product/' . $financial_product->id))
                ->redirect();
        } catch (Exception $e) {
            return $this->response->message($e->getMessage())
                ->code(400)
                ->status('error')
                ->url(guard_url('financial_product/' . $financial_product->id))
                ->redirect();
        }
    }
    public function destroy(Request $request,FinancialProduct $financial_product)
    {
        try {
            $this->repository->forceDelete([$financial_product->id]);

            return $this->response->message(trans('messages.success.deleted', ['Module' => trans('financial_product.name')]))
                ->status("success")
                ->code(202)
                ->url(guard_url('financial_product'))
                ->redirect();

        } catch (Exception $e) {

            return $this->response->message($e->getMessage())
                ->status("error")
                ->code(400)
                ->url(guard_url('financial_product'))
                ->redirect();
        }
    }
    public function destroyAll(Request $request)
    {
        try {
            $data = $request->all();
            $ids = $data['ids'];
            $this->repository->forceDelete($ids);

            return $this->response->message(trans('messages.success.deleted', ['Module' => trans('financial_product.name')]))
                ->status("success")
                ->code(202)
                ->url(guard_url('financial_product'))
                ->redirect();

        } catch (Exception $e) {
            return $this->response->message($e->getMessage())
                ->status("error")
                ->code(400)
                ->url(guard_url('financial_product'))
                ->redirect();
        }
    }
}
