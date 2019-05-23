<?php
namespace App\Services;

use App\Helpers\ErrorCode;
use GuzzleHttp\Client;

class AmapService
{
    public function __construct()
    {
        $this->key = config('amap.web_keu');
        $this->client = new Client();
    }
    public function geocode_geo()
    {
        $url = "https://restapi.amap.com/v3/geocode/regeo";
        $res = $this->client->request("GET", $url);

    }

}