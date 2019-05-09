<?php

namespace App\Http\Controllers\Api;

use App\Repositories\Eloquent\PageRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController;
use App\Models\Banner;
use App\Models\User;
use Log;

class UserController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getUser(Request $request)
    {
        $user = app(User::class)->findUserByToken($request->token);

        return response()->json([
            'code' => '200',
            'data' => $user,
        ]);
    }
}
