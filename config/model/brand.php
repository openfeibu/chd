<?php
return [
    /*
     * Package .
     */
    'package'  => 'brand',

    /*
     * Modules .
     */
    'modules'  => ['brand','brand_color'],

    /*
     * Views for the page  .
     */
    'views'    => ['default' => 'Default', 'left' => 'Left menu', 'right' => 'Right menu'],

    'brand'     => [
        'model'        => 'App\Models\Brand',
        'table'        => 'brands',
        'primaryKey'   => 'id',
        'hidden'       => [],
        'visible'      => [],
        'guarded'      => ['*'],
        'dates'        => ['deleted_at'],
        'fillable'     => ['name','parent_id','logo','listorder','letter','status','hot','displaying'],
        'translate'    => ['name','parent_id','logo','listorder','letter','status','hot','displaying'],
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
    'brand_color'     => [
        'model'        => 'App\Models\BrandColor',
        'table'        => 'brand_colors',
        'primaryKey'   => 'id',
        'hidden'       => [],
        'visible'      => [],
        'guarded'      => ['*'],
        'dates'        => ['deleted_at'],
        'fillable'     => ['brand_id','type','name','listorder','displaying'],
        'translate'    => ['brand_id','type','name','listorder','displaying'],
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