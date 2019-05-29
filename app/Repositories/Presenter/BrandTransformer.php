<?php

namespace App\Repositories\Presenter;

use League\Fractal\TransformerAbstract;

class BrandTransformer extends TransformerAbstract
{
    public function transform(\App\Models\Brand $brand)
    {
        return [
            'id' => $brand->id,

        ];
    }
}
