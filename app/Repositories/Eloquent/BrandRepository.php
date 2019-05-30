<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Eloquent\BrandRepositoryInterface;
use App\Repositories\Eloquent\BaseRepository;

class BrandRepository extends BaseRepository implements BrandRepositoryInterface
{
    public function model()
    {
        return config('model.brand.brand.model');
    }
    public function getAllChildIds($parent_id=0)
    {
        $ids = [];
        $child_ids = $this->getChildIds($parent_id);
        $ids = array_merge($ids,$child_ids);
        foreach ($child_ids as $key => $child_id)
        {
            $arr = $this->getAllChildIds($child_id);
            $ids =   array_merge($ids,$arr);
        }
        return $ids;
    }
    public function getChildIds($parent_id)
    {
        $ids = $this->model->where(['parent_id' => $parent_id])->pluck('id')->toArray();

        return $ids;
    }
}