<?php

namespace App\Http\Controllers\Admin\Page;

use App\Http\Controllers\Admin\SinglePageResourceController as BaseController;
use App\Http\Requests\PageRequest;
use Illuminate\Http\Request;
use App\Repositories\Eloquent\PageRepositoryInterface;
use App\Models\Page;

/**
 * Resource controller class for page.
 */
class AboutRentResourceController extends BaseController
{
    public function __construct(PageRepositoryInterface $page)
    {
        parent::__construct($page);
        $this->slug = 'about_rent';
        $this->category_id = 7;
        $this->url = guard_url('page/about_rent/show');
        $this->title = trans('page.about_rent.name');
        $this->view_folder = 'page.about_rent';
    }
}