<?php

namespace App\Repositories\Presenter;

use League\Fractal\TransformerAbstract;

class FinancialProductTransformer extends TransformerAbstract
{
    public function transform(\App\Models\FinancialProduct $financial_product)
    {
        return [
            'id' => $financial_product->id,
            'name' => $financial_product->name,
            'auth_file_name' => $financial_product->auth_file_name,
            'category_name' => $financial_product->financial_category->name,
            'content' => $financial_product->content,
        ];
    }
}
