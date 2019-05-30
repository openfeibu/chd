<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Eloquent\FinancialProductRepositoryInterface;
use App\Repositories\Eloquent\BaseRepository;

class FinancialProductRepository extends BaseRepository implements FinancialProductRepositoryInterface
{
    public function model()
    {
        return config('model.financial.financial_product.model');
    }

}