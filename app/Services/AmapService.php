<?php
namespace App\Services;

use App\Helpers\ErrorCode;
use GuzzleHttp\Client;

class AmapService
{
    public function __construct()
    {
        $this->key = config('amap.web_key');
        $this->client = new Client();
    }
    public function geocode_regeo($location)
    {
        $url = "https://restapi.amap.com/v3/geocode/regeo?key=".$this->key."&location=".$location.'&output=JSON';
        $res = $this->client->request("GET", $url);
var_dump($url);exit;
        var_dump(json_decode($res));exit;
        return $res;
    }

}