<?php

namespace App\Repositories\Presenter;

use App\Repositories\Presenter\FractalPresenter;

class BrandPresenter extends FractalPresenter
{

    /**
     * Prepare data to present
     *
     * @return \App\Repositories\Eloquent\BrandTransformer
     */
    public function getTransformer()
    {
        return new BrandTransformer();
    }
}
