<?php

namespace App\Helpers;

use Session;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ApiHelper{
    static function apiGet($url)
    {
        $client = new \GuzzleHttp\Client();
        $header = [
            'headers' => ['content-type' => 'application/json',
            'Accept' => 'application/json',
            'key' => '98d55d140623d2969d76346f8787c11a'],
        ];
        $request = $client->get($url, $header);
        return $request->getBody();
    }

    static function apiPost($url, $body)
    {

        $client = new Client([
            'headers' => ['content-type' => 'application/json', 'Accept' => 'application/json','key' => '98d55d140623d2969d76346f8787c11a'],
        ]);
        $response = $client->request('POST', $url, $body);
        return $response->getBody();
    }
}
