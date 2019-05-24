<?php

namespace App\Models;

use Hash,Auth;
use App\Models\Auth as AuthModel;
use App\Traits\Database\Slugger;
use App\Traits\Database\DateFormatter;
use App\Traits\Filer\Filer;
use Illuminate\Support\Facades\Request as RequestFacades;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class User extends AuthModel
{
    use Filer, Slugger, DateFormatter;

    /**
     * Configuartion for the model.
     *
     * @var array
     */
    protected $config = 'model.user.user.model';

    public function findUserByToken($token)
    {
        return self::select('id','nickname','avatar_url','city','token','phone','open_id','session_key')->where('token', $token)->first();
    }
    public static function getUser()
    {
         $token = RequestFacades::input('token','');
         $user = self::select('id','nickname','avatar_url','city','token','phone','open_id','session_key')->where('token', $token)->first();
        if(!$user)
        {
            throw new UnauthorizedHttpException('jwt-auth', '未登录');
        }
        return $user;
    }
}