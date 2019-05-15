<?php
return [
    /*
     * Package .
     */
    'package'  => 'financial',

    /*
     * Modules .
     */
    'modules'  => ['financial_product'],

    /*
     * Views for the page  .
     */
    'views'    => ['default' => 'Default', 'left' => 'Left menu', 'right' => 'Right menu'],

    'financial_product'     => [
        'model'        => 'App\Models\FinancialProduct',
        'table'        => 'financial_product',
        'primaryKey'   => 'id',
        'hidden'       => [],
        'visible'      => [],
        'guarded'      => ['*'],
        'dates'        => ['deleted_at'],
        'fillable'     => ['category_id','name','content'],
        'translate'    => ['category_id','name','content'],
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
    'financial_category'     => [
        'model'        => 'App\Models\FinancialCategory',
        'table'        => 'financial_products',
        'primaryKey'   => 'id',
        'hidden'       => [],
        'visible'      => [],
        'guarded'      => ['*'],
        'dates'        => ['deleted_at'],
        'fillable'     => ['id','name'],
        'translate'    => ['id','name'],
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
    'car_financial_product' => [
        'model'        => 'App\Models\CarFinancialProduct',
        'table'        => 'car_financial_products',
        'primaryKey'   => 'id',
        'hidden'       => [],
        'visible'      => [],
        'guarded'      => ['*'],
        'dates'        => ['deleted_at'],
        'fillable'     => ['car_id','financial_product_id','down','ratio','month_installment','periods'],
        'translate'    => ['car_id','financial_product_id','down','ratio','month_installment','periods'],
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