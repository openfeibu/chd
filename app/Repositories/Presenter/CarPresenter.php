<?php

namespace App\Repositories\Presenter;

use App\Repositories\Presenter\FractalPresenter;

class CarPresenter extends FractalPresenter
{

    /**
     * Prepare data to present
     *
     * @return \App\Repositories\Eloquent\CarTransformer
     */
    public function getTransformer()
    {
        return new CarTransformer();
    }
}
