<?php

namespace App\Services\Mapbox;

use GuzzleHttp\Client;

class PlacesService
{
    public function __construct(
        protected Client $client
    ) {}

    public function search(array $coords, string $bbox, array $categories): array
    {
        $results = [];

        foreach ($categories as $category) {

            $url =
                "https://api.mapbox.com/search/searchbox/v1/category/"
                . urlencode($category)
                . "?proximity={$coords['lng']},{$coords['lat']}"
                . "&bbox={$bbox}"
                . "&limit=5"
                . "&access_token=" . env('MAPBOX_TOKEN');

            $response = $this->client->get($url);

            $data = json_decode($response->getBody(), true);

            if (!empty($data['features'])) {
                $results = array_merge($results, $data['features']);
            }
        }

        return $results;
    }
}
