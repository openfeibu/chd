<?php
return [
    /*
     * Package .
     */
    'package'  => 'car',

    /*
     * Modules .
     */
    'modules'  => ['car'],

    /*
     * Views for the page  .
     */
    'views'    => ['default' => 'Default', 'left' => 'Left menu', 'right' => 'Right menu'],

    'car'     => [
        'model'        => 'App\Models\Car',
        'table'        => 'cars',
        'primaryKey'   => 'id',
        'hidden'       => [],
        'visible'      => [],
        'guarded'      => ['*'],
        'dates'        => ['deleted_at'],
        'fillable'     => ['name','year','type','price','listorder','configure','selling_price','commercial_insurance_price','production_date','emission_standard','note','image','category','content','recommend_type'],
        'translate'    => ['name','year','type','price','listorder','configure'],
        'configure' => [

        ],
        'production_date' => [
            '一个月内','三个月内','六个月内','九个月内','一年内','两年内','三年内','三年以上'
        ],
        'emission_standard' => [
            '国四','国五','国六'
        ],
        'note' => [
            '4s店票','汽贸票','增票'
        ],
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