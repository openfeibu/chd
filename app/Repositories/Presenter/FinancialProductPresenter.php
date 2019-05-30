<?php

namespace App\Repositories\Presenter;

use App\Repositories\Presenter\FractalPresenter;

class FinancialProductPresenter extends FractalPresenter
{

    /**
     * Prepare data to present
     *
     * @return \App\Repositories\Eloquent\FinancialProductTransformer
     */
    public function getTransformer()
    {
        return new FinancialProductTransformer();
    }
}
