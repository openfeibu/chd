<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Eloquent\CarRepositoryInterface;
use App\Repositories\Eloquent\BaseRepository;

class BrandRepository extends BaseRepository implements CarRepositoryInterface
{
    public function model()
    {
        return config('model.brand.brand.model');
    }
}