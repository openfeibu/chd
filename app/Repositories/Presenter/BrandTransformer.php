<?php

namespace App\Repositories\Presenter;

use League\Fractal\TransformerAbstract;

class BrandTransformer extends TransformerAbstract
{
    public function transform(\App\Models\Brand $brand)
    {
        return [
            'id' => $brand->id,
            'name' => $brand->name,
            'parent_id' => $brand->parent_id,
            'logo' => handle_image_url($brand->logo),
            'letter' => $brand->letter,
            'status' => $brand->status,
            'displaying' => $brand->displaying,
        ];
    }
}
