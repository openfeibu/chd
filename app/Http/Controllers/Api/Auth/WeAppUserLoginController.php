<?php

namespace App\Http\Controllers\Api\Auth;

use App\Repositories\Eloquent\PageRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController;
use App\Models\User;
use \GuzzleHttp\Client;
use Log;
use App\Helpers\Constants as Constants;
use App\Services\WXBizDataCryptService;

class WeAppUserLoginController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function login(Request $request)
    {
        $code = $request->input('code');
        $encryptedData = $request->input('encryptedData');
        $iv = $request->input('iv');

        $sessionKey = $this->getSessionKey($code);
        $token = $this->generatetoken($sessionKey);

        $WXBizDataCryptService = new WXBizDataCryptService(config('weapp.appid'),$sessionKey);

        $errCode = $WXBizDataCryptService->decryptData($encryptedData, $iv, $data );

        if ($errCode != 0) {
            return response()->json([
                'code' => '400',
                'message' => $errCode,
            ]);
        }

        $user_info = json_decode($data);

        $this->storeUser($user_info, $token, $sessionKey);

        $user = app(User::class)->findUserByToken($token);

        return response()->json([
            'code' => '200',
            'data' => $user,
        ]);
    }
    /**
     * 通过 code 换取 session key
     * @param string $code
     * @return string $session_key
     * @throws \Exception
     */
    public function getSessionKey($code)
    {
        $appId = config("weapp.appid");
        $appSecret = config("weapp.secret");
        list($session_key, $openid) = array_values($this->getSessionKeyDirectly($appId, $appSecret, $code));
        return $session_key;
    }
    /**
     * 直接请求微信获取 session key
     * @param string $appId
     * @param string $appSecret
     * @param string $code
     * @return array { $session_key, $openid }
     * @throws \Exception
     */
    private function getSessionKeyDirectly($appId, $appSecret, $code)
    {
        $requestParams = [
            'appid' => $appId,
            'secret' => $appSecret,
            'js_code' => $code,
            'grant_type' => 'authorization_code'
        ];
        $client = new Client();
        $url = config('weapp.code2session_url') . http_build_query($requestParams);
        $res = $client->request("GET", $url, [
            'timeout' => Constants::getNetworkTimeout()
        ]);
        $status = $res->getStatusCode();
        $body = json_decode($res->getBody(), true);

        if ($status !== 200 || !$body || isset($body['errcode'])) {
            throw new \App\Exceptions\OutputServerMessageException(Constants::E_LOGIN_FAILED);
        }
        return $body;
    }
    public function generatetoken($sessionKey)
    {
        $this->token = sha1($sessionKey . mt_rand());
        return $this->token;
    }

    public function storeUser($user_info, $token, $session_key)
    {
        $open_id = $user_info->openId;
        $res = User::where('open_id', $open_id)->get();
        if (empty($res->toArray())) {
            User::create([
                'open_id' => $user_info->openId,
                'avatar_url' => $user_info->avatarUrl,
                'nickname' => $user_info->nickName,
                'session_key' => $session_key,
                'token' => $token,
                'city' => $user_info->city,
            ]);
        } else {
            User::where('open_id', $open_id)->update([
                'token' => $token,
                'session_key' => $session_key
            ]);
        }
    }

}