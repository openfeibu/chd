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

        $parent_id = $request->input('parent_id',0);

        if ($this->response->typeIs('json')) {
            $data = $this->repository;
            if($parent_id !== '')
            {
                $data = $data->where(['parent_id' => $parent_id]);
            }
            $data = $data->setPresenter(\App\Repositories\Presenter\BrandPresenter::class)
                ->orderBy('letter','asc')
                ->getDataTable($limit);

            return $this->response
                ->success()
                ->count($data['recordsTotal'])
                ->data($data['data'])
                ->output();

        }
        return $this->response->title(trans('brand.name'))
            ->data(compact('parent_id'))
            ->view('brand.index')
            ->output();

    }
    public function create(Request $request)
    {
        $brand = $this->repository->newInstance([]);

        return $this->response->title(trans('brand.name'))
            ->view('brand.create')
            ->data(compact('brand'))
            ->output();
    }
    public function store(Request $request)
    {
        try {
            $attributes = $request->all();

            $brand = $this->repository->create($attributes);

            return $this->response->message(trans('messages.success.created', ['Module' => trans('brand.name')]))
                ->code(0)
                ->status('success')
                ->url(guard_url('brand'))
                ->redirect();
        } catch (Exception $e) {
            return $this->response->message($e->getMessage())
                ->code(400)
                ->status('error')
                ->url(guard_url('brand'))
                ->redirect();
        }
    }
    public function show(Request $request,Brand $brand)
    {
        if ($brand->exists) {
            $view = 'brand.show';
        } else {
            $view = 'brand.create';
        }

        return $this->response->title(trans('view') . ' ' . trans('brand.name'))
            ->data(compact('brand'))
            ->view($view)
            ->output();
    }
    public function update(Request $request,Brand $brand)
    {
        try {
            $attributes = $request->all();

            $brand->update($attributes);

            return $this->response->message(trans('messages.success.updated', ['Module' => trans('brand.name')]))
                ->code(0)
                ->status('success')
                ->url(guard_url('brand/' . $brand->id))
                ->redirect();
        } catch (Exception $e) {
            return $this->response->message($e->getMessage())
                ->code(400)
                ->status('error')
                ->url(guard_url('brand/' . $brand->id))
                ->redirect();
        }
    }
    public function destroy(Request $request,Brand $brand)
    {
        try {
            $child_ids = $this->repository->getAllChildIds($brand->id);

            array_push($child_ids,$brand->id);

            $this->repository->forceDelete($child_ids);

            Car::whereIn('type',$child_ids)->delete();

            return $this->response->message(trans('messages.success.deleted', ['Module' => trans('brand.name')]))
                ->status("success")
                ->code(202)
                ->url(guard_url('brand'))
                ->redirect();

        } catch (Exception $e) {

            return $this->response->message($e->getMessage())
                ->status("error")
                ->code(400)
                ->url(guard_url('brand'))
                ->redirect();
        }
    }
    public function destroyAll(Request $request)
    {
        try {
            $data = $request->all();
            $ids = $data['ids'];

            $all_ids = [];
            foreach ($ids as $id)
            {
                $child_ids = $this->repository->getAllChildIds($id);
                array_push($child_ids,$id);
                $all_ids = array_merge($all_ids,$child_ids);
            }
            $this->repository->forceDelete($all_ids);
            Car::whereIn('type',$all_ids)->delete();

            return $this->response->message(trans('messages.success.deleted', ['Module' => trans('brand.name')]))
                ->status("success")
                ->code(202)
                ->url(guard_url('brand'))
                ->redirect();

        } catch (Exception $e) {
            return $this->response->message($e->getMessage())
                ->status("error")
                ->code(400)
                ->url(guard_url('brand'))
                ->redirect();
        }
    }

}
