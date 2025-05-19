<?php

namespace App\Services\External\CatAPI;

use GuzzleHttp\Client;

class CatApiService
{
    protected $client;
    protected $baseUri;
    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client();
        $this->baseUri = config('services.cat_api.base_uri');
        $this->apiKey =  config('services.cat_api.key');
    }

    public function catApiRequest($method, $endpoint, $params = [])
    {
        

        $options = [
            'headers' => [
                'x-api-key' => $this->apiKey,
                'Accept' => 'application/json'
            ]
        ];

        //validate if the request will have parameters
        if (!empty($params)) {
            $options['query'] = $params;
        }
        //make the request to the API
        $response = $this->client->request($method, $this->baseUri . $endpoint, $options);
        return json_decode($response->getBody(), true);
    }
}
