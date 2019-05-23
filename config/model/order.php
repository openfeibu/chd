<?php
return [
    /*
     * Package .
     */
    'package'  => 'order',

    /*
     * Modules .
     */
    'modules'  => ['order'],

    /*
     * Views for the page  .
     */
    'views'    => ['default' => 'Default', 'left' => 'Left menu', 'right' => 'Right menu'],

    'order'     => [
        'model'        => 'App\Models\Order',
        'table'        => 'orders',
        'primaryKey'   => 'id',
        'hidden'       => [],
        'visible'      => [],
        'guarded'      => ['*'],
        'dates'        => ['deleted_at'],
        'fillable'     => ['user_id','car_id','car_name','company','linkman','phone','city','color','commercial_insurance_price','is_commercial_insurance','selling_price','car_financial_product_id','financial_product_name','down','ratio','month_installment','periods','is_financial','financial_category_id','financial_category_name','order_financial_id','deposit','status','created_at','updated_at'],
        'translate'    => ['name','year','type','price','listorder','configure'],
        'upload_folder' => '/page/page',
        'encrypt'      => ['id'],
        'revision'     => ['name'],
        'perPage'      => '20',
        'search'        => [
            'name'  => 'like',
            'url'  => 'like',
            'order'  => 'like'
        ],
    ],
];