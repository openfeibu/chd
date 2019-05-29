<?php

namespace App\Repositories\Presenter;

use App\Repositories\Presenter\FractalPresenter;

class OrderPresenter extends FractalPresenter
{

    /**
     * Prepare data to present
     *
     * @return \App\Repositories\Eloquent\Presenter\OrderTransformer
     */
    public function getTransformer()
    {
        return new OrderTransformer();
    }
}
