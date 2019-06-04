<?php

namespace App\Repositories\Presenter;

use League\Fractal\TransformerAbstract;

class CarTransformer extends TransformerAbstract
{
    public function transform(\App\Models\Car $car)
    {
        return [
            'id' => $car->id,
            'name' => $car->name,
            'brand_name' => isset($car->brand)  && $car->brand ? $car->brand->name : '未知',
            'price' => $car->price,
            'selling_price' => $car->selling_price,
            'commercial_insurance_price' => $car->commercial_insurance_price,
            'production_date' => $car->production_date,
            'emission_standard' => $car->emission_standard,
            'note' => $car->note,
            'year' => $car->year,
            'content' => $car->content,
        ];
    }
}
