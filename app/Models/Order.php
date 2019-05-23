<?php

namespace App\Models;

use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\BaseModel;
use App\Traits\Database\Slugger;
use App\Traits\Filer\Filer;
use App\Traits\Hashids\Hashids;
use App\Traits\Trans\Translatable;
use App\Models\Car;
use App\Models\BrandColor;

class Order extends BaseModel
{
    use Filer, Hashids, Slugger, Translatable, LogsActivity;

    /**
     * Configuartion for the model.
     *
     * @var array
     */
    protected $config = 'model.order.order';

    protected $appends = ['status_desc','transfer_voucher_image_url','total_price'];       // 表里没有的字段

    public function getStatusDescAttribute()
    {
        $status = $this->attributes['status'];
        return trans('order.status.'.$status);
    }
    public function getTransferVoucherImageUrlAttribute()
    {
        return $this->attributes['transfer_voucher_image'] ? url('/image/original/'.$this->attributes['transfer_voucher_image']) : '';
    }
    public function getTotalPriceAttribute()
    {
        return $this->attributes['selling_price'] * 10000 +  $this->attributes['commercial_insurance_price'];
    }
}
