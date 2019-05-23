<?php

namespace App\Http\Controllers\Api;


use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController;
use App\Models\Banner;
use App\Models\Setting;
use Log;

class HomeController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getBank(Request $request)
    {
        $data = [
            'bank' => setting('bank'),
            'bank_name' => setting('bank_name'),
            'bank_account' => setting('bank_account'),
        ];
        return response()->json([
            'code' => '200',
            'data' => $data,
        ]);
    }
    public function getAuthFile(Request $request)
    {
        $icbc_auth_file = url('image/original/'.setting('icbc_auth_file'));
        $icbc_auth_file_name = setting('icbc_auth_file','title');
        return response()->json([
            'code' => '200',
            'data' => [
                'icbc_file' => [
                    'name' => $icbc_auth_file_name,
                    'image' =>  $icbc_auth_file,
                ],
            ],
        ]);
    }
}
