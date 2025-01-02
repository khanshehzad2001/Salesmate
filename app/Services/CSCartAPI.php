<?php

namespace App\Services;

use GuzzleHttp\Client;

class CSCartAPI
{
    protected $url;
    protected $http;
    protected $headers;

    public function __construct(Client $client)
    {
        $client = new Client(['verify' => false]);
        $this->url =  config('services.cscart.url');
        $this->http = $client;
        
        $this->headers = [
            'cache-control' => 'no-cache',
            'Authorization' => config('services.cscart.authorization'),
        ];
        // $guzzleClient = new \GuzzleHttp\Client(array( 'curl' => array( CURLOPT_SSL_VERIFYPEER => false, ), ));
        // $client->setHttpClient($guzzleClient);
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

    private function postResponse(string $uri = null, array $post_params = [])
    {
        $full_path = $this->url;
        $full_path .= $uri;

        $request = $this->http->post($full_path, [
            'headers'         => $this->headers,
            'timeout'         => 30,
            'connect_timeout' => true,
            'http_errors'     => true,
            'form_params'     => $post_params,
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

    public function getCategories($params)
    {
        //dd($params);
        return $this->getResponse($params);
    }
}