<?php

namespace App\Models;

use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\BaseModel;
use App\Traits\Database\Slugger;
use App\Traits\Filer\Filer;
use App\Traits\Hashids\Hashids;
use App\Traits\Trans\Translatable;

class Brand extends BaseModel
{
    use Filer, Hashids, Slugger, Translatable, LogsActivity;

    /**
     * Configuartion for the model.
     *
     * @var array
     */
    protected $config = 'model.brand.brand';

    public $timestamps = false;

    public function getSubIds($ids,$all_sub_ids =array())
    {
        if(is_array($ids))
        {
            $sub_ids = self::whereIn('parent_id',$ids)->pluck('id')->toArray();
        }else{
            $sub_ids = self::where('parent_id',$ids)->pluck('id')->toArray();
        }

        if ($sub_ids) {
            $all_sub_ids = array_merge($all_sub_ids,$sub_ids);
            $all_sub_ids = $this->getSubIds($sub_ids,$all_sub_ids);
        }
        return $all_sub_ids;
    }

}
