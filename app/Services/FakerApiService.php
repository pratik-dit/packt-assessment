<?php

namespace App\Services;

use GuzzleHttp\Client;
use Exception;

class FakerApiService
{
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function getBooks($limit)
    {
        $url = config('services.fakerapi.books_url');
        try{
            $response = $this->client->request('GET', "$url?_quantity=$limit",[
                'headers' => [
                    'Accept'     => 'application/json'
                ]
            ]);
            return json_decode($response->getBody()->getContents());
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}