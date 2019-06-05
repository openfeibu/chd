<?php

namespace App\Models;

use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\BaseModel;
use App\Traits\Database\Slugger;
use App\Traits\Filer\Filer;
use App\Traits\Hashids\Hashids;
use App\Traits\Trans\Translatable;

class CarFinancialProduct extends BaseModel
{
    use Filer, Hashids, Slugger, Translatable, LogsActivity;

    /**
     * Configuartion for the model.
     *
     * @var array
     */
    protected $config = 'model.financial.car_financial_product';

    public static function getCarFirstFinancial($car_id)
    {
        return self::select('down','ratio','month_installment','periods')->where('car_id',$car_id)->orderBy('id','asc')->where('down','>',0)->first();
    }
    public static function getCarFirstFinancials($car_id)
    {
        return self::select('car_financial_products.id as car_financial_product_id','car_financial_products.down','car_financial_products.ratio','car_financial_products.month_installment','car_financial_products.periods','financial_products.name','financial_products.content')->join('financial_products','financial_products.id','=','car_financial_products.financial_product_id')->where('car_financial_products.car_id',$car_id)->where('car_financial_products.down','>',0)->orderBy('car_financial_products.id','asc')->get();
    }
}
