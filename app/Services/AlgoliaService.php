<?php

namespace App\Services;
use Algolia\AlgoliaSearch\SearchClient;
use App\Http\Controllers;

class AlgoliaService
{
    protected $client;

    public function __construct()
    {
        $this->client = SearchClient::create(
            env('ALGOLIA_APP_ID'),
            env('ALGOLIA_SECRET')
        );
    }

    public function searchProducts($query)
    {
        if (empty($query)) {
            return [];
        }

        $index = $this->client->initIndex('prod_smproducts');
        $searchResult = $index->search($query, [
            'hitsPerPage' => 100,
            'page' => 0
        ]);

        return $searchResult['hits'];
    }
}