<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\ResourceController as BaseController;
use App\Http\Requests\PageRequest;
use Illuminate\Http\Request;
use App\Repositories\Eloquent\PageRepositoryInterface;
use App\Models\Page;

/**
 * Resource controller class for page.
 */
class SinglePageResourceController extends BaseController
{
    public function __construct(PageRepositoryInterface $page)
    {
        parent::__construct();
        $this->repository = $page;

        $this->repository = $this->repository
            ->pushCriteria(\App\Repositories\Criteria\RequestCriteria::class)
            ->pushCriteria(\App\Repositories\Criteria\PageResourceCriteria::class);
    }
    public function store(Request $request)
    {
        try {
            $attributes = $request->all();
            $attributes['slug'] = $this->slug;
            $attributes['category_id'] = $this->category_id;
            $page = $this->repository->create($attributes);

            return $this->response->message(trans('messages.success.created', ['Module' => $this->title]))
                ->code(204)
                ->status('success')
                ->url($this->url)
                ->redirect();
        } catch (Exception $e) {
            return $this->response->message($e->getMessage())
                ->code(400)
                ->status('error')
                ->url($this->url)
                ->redirect();
        }
    }
    public function show(Request $request)
    {
        $page = $this->repository->getPage($this->slug);
        if(!empty($page))
        {
            $view = $this->view_folder.'.show';
        }else{
            $view = $this->view_folder.'.create';
        }
        return $this->response->title(trans('app.view') . ' ' . $this->title)
            ->data(compact('page'))
            ->view($view)
            ->output();
    }
    public function update(Request $request,Page $page)
    {
        try {
            $attributes = $request->all();

            $page->update($attributes);
            return $this->response->message(trans('messages.success.updated', ['Module' => $this->title]))
                ->code(204)
                ->status('success')
                ->url($this->url)
                ->redirect();
        } catch (Exception $e) {
            return $this->response->message($e->getMessage())
                ->code(400)
                ->status('error')
                ->url($this->url)
                ->redirect();
        }
    }

}