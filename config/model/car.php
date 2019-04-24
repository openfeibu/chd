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
        'fillable'     => ['name','year','type','price','listorder','configure'],
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