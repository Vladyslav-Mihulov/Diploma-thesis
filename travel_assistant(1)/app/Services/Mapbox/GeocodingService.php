<?php

namespace App\Services\Mapbox;

use GuzzleHttp\Client;

class GeocodingService
{
    public function __construct(
        protected Client $client
    ) {}

    public function geocode(array $data): array
    {
        $fullAddress = urlencode(
            ($data['address'] ?? '') . ' ' .
                ($data['city'] ?? '') . ' ' .
                ($data['state'] ?? '') . ' ' .
                ($data['postcode'] ?? '')
        );

        $url = "https://api.mapbox.com/search/geocode/v6/forward?q={$fullAddress}&access_token=" . env('MAPBOX_TOKEN');

        $response = $this->client->get($url);

        $data = json_decode($response->getBody(), true);

        if (
            empty($data['features']) ||
            !isset($data['features'][0])
        ) {
            return [
                'error' => 'Address not found'
            ];
        }

        $feature = $data['features'][0];

        $coords = $feature['geometry']['coordinates'];

        $resolvedAddress =
            $feature['properties']['full_address']
            ?? $feature['properties']['name']
            ?? $feature['place_name']
            ?? null;

        return [
            'lng' => $coords[0],
            'lat' => $coords[1],
            'resolved_address' => $resolvedAddress,
        ];
    }
}
