<?php

namespace App\Services;

use GuzzleHttp\Client;

class RainusAPI
{
    protected $url;
    protected $http;
    protected $headers;

    public function __construct(Client $client)
    {

        $this->url =  config('services.rainus.url');
        $this->http = $client;
        $this->headers = [
            'cache-control' => 'no-cache',
            'Access-Token' => config('services.rainus.authorization'),
        ];
    }

    private function getResponse(string $uri = null)
    {
        $full_path = $this->url;
        $full_path .= $uri;

        $request = $this->http->get($full_path, [
            'headers'         => $this->headers,
            'timeout'         => 30,
            'connect_timeout' => true,
            'http_errors'     => true,
        ]);

        $response = $request ? $request->getBody()->getContents() : null;
        $status = $request ? $request->getStatusCode() : 500;

        if ($response && $status === 200 && $response !== 'null') {
            return (object) json_decode($response);
        }

        return null;
    }

    private function postResponse(string $uri = null, $body, array $post_params = [])
    {
        $full_path = $this->url;
        $full_path .= $uri;

        $request = $this->http->post($full_path, [
            'headers'         => $this->headers,
            'timeout'         => 30,
            'connect_timeout' => true,
            'http_errors'     => true,
            'form_params'     => $post_params,
            'body' => $body
        ]);

        $response = $request ? $request->getBody()->getContents() : null;
        $status = $request ? $request->getStatusCode() : 500;

        if ($response && $status === 200 && $response !== 'null') {
            return (object) json_decode($response);
        }

        return null;
    }

    public function getProducts($params)
    {
        return $this->getResponse($params);
    }

    public function postProducts($url, $body)
    {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://ecity.rainus.io/api/product',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>$body,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Access-Token: ' . config('services.rainus.authorization')
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }

    public function getToken($params)
    {
      //  return $this->getResponse($params);
    }

    public function createToken($params)
    {
       // return $this->getResponse($params);
    }

}