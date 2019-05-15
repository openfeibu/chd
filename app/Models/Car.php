<?php

namespace App\Models;

use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\BaseModel;
use App\Traits\Database\Slugger;
use App\Traits\Filer\Filer;
use App\Traits\Hashids\Hashids;
use App\Traits\Trans\Translatable;

class Car extends BaseModel
{
    use Filer, Hashids, Slugger, Translatable, LogsActivity;

    /**
     * Configuartion for the model.
     *
     * @var array
     */
    protected $config = 'model.car.car';

    public $timestamps = false;

    protected $appends = ['is_instalment','is_rent','is_financial','is_full'];

    public function getIsInstalmentAttribute()
    {
        $category = $this->attributes['category'];
        return strpos($category,'instalment') ? true : false;
    }

    public function getIsRentAttribute()
    {
        $category = $this->attributes['category'];
        return strpos($category,'rent') ? true : false;
    }
    public function getIsFullAttribute()
    {
        $category = $this->attributes['category'];
        return strpos($category,'full') ? true : false;
    }
    public function getIsFinancialAttribute()
    {
        $category = $this->attributes['category'];
        return strpos($category,'rent') || strpos($category,'instalment') ? true : false;
    }
}
