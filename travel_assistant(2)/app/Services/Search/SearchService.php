<?php

namespace App\Services\Search;

use App\Services\Mapbox\GeocodingService;
use App\Services\Mapbox\PlacesService;
use App\Services\Ai\GeminiService;
use App\Http\Requests\SearchRequest;
use App\Models\Search;
use App\Models\Result;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class SearchService
{
    public function __construct(
        protected GeocodingService $geo,
        protected PlacesService $places,
        protected GeminiService $ai
    ) {}

    protected array $categoryMap = [
        'beach' => ['beach'],
        'hiking' => ['mountain', 'ski_trail', 'trailhead'],
        'relax' => ['spa', 'sauna', 'water_park', 'hotel'],
        'culture' => ['museum', 'planetarium', 'monument', 'art_gallery', 'historic_site'],
        'gastronomic' => ['restaurant', 'cafe', 'bar', 'bakery'],
        'city' => ['tourist_attraction', 'shopping_mall', 'viewpoint'],
        'nature' => ['park', 'forest', 'lake', 'waterfall']
    ];

    public function handle(SearchRequest $request): array
    {
        $formData = $this->getFormData($request);

        $coordinates = $this->geo->geocode($formData);
        $resolvedAddress = $coordinates['resolved_address'] ?? null;

        if (isset($coordinates['error'])) {
            return [
                'error' => $coordinates['error']
            ];
        }

        $bbox = $this->buildBoundingBox(
            $coordinates['lng'],
            $coordinates['lat'],
            $formData['distance']
        );

        $places = $this->places->search(
            $coordinates,
            $bbox,
            $this->categoryMap[$formData['travelType']] ?? ['tourist_attraction']
        );

        if (empty($places)) {
            return ['error' => 'Places not found'];
        }

        $cleanPlaces = $this->formatPlacesForAI($places);

        $aiResult = $this->ai->generate($cleanPlaces);

        $final = $this->mergeAIResults($cleanPlaces, $aiResult);

        if (Auth::check()) {
            $this->saveSearchHistory($formData, $coordinates, $final);
        }

        return [
            'places' => $final,
            'resolved_address' => $resolvedAddress,
            'coordinates' => [
                'lng' => $coordinates['lng'],
                'lat' => $coordinates['lat'],
            ],
        ];
    }

    private function getFormData(SearchRequest $request): array
    {
        return [
            'address' => $request->input('address_address-search'),
            'city' => $request->input('city'),
            'state' => $request->input('state'),
            'postcode' => $request->input('postcode'),
            'travelType' => $request->input('travel-type'),
            'distance' => (int)$request->input('travel-distance')
        ];
    }

    private function buildBoundingBox(float $lng, float $lat, int $distance): string
    {
        $distanceDeg = $distance / 111;

        return implode(',', [
            $lng - $distanceDeg,
            $lat - $distanceDeg,
            $lng + $distanceDeg,
            $lat + $distanceDeg
        ]);
    }

    private function formatPlacesForAI(array $places): array
    {
        return array_map(function ($place, $i) {
            return [
                'id' => $i,
                'name' => $place['properties']['name'] ?? null,
                'address' => $place['properties']['full_address'] ?? null,
                'distance' => $place['properties']['distance'] ?? null,
                'category' => $place['properties']['maki'] ?? null,

                'lat' => $place['geometry']['coordinates'][1] ?? null,
                'lng' => $place['geometry']['coordinates'][0] ?? null
            ];
        }, $places, array_keys($places));
    }

    private function mergeAIResults(array $places, array $aiResult): array
    {
        $final = [];

        foreach ($places as $place) {

            $aiData = collect($aiResult)
                ->firstWhere('id', $place['id']);

            $rating = preg_replace(
                '/[^0-9.]/',
                '',
                $aiData['rating'] ?? 0
            );

            $final[] = array_merge($place, [
                'description' => $aiData['description'] ?? null,
                'rating' => (float)$rating
            ]);
        }

        usort(
            $final,
            fn($a, $b) =>
            $b['rating'] <=> $a['rating']
        );


        return $final;
    }

    private function saveSearchHistory(array $formData, array $coordinates, array $places): void
    {
        $search = Search::create([
            'users_id' => Auth::id(),
            'address' => $formData['address'],
            'city' => $formData['city'],
            'state' => $formData['state'],
            'postcode' => $formData['postcode'],
            'lat' => $coordinates['lat'],
            'lng' => $coordinates['lng'],
            'category' => $formData['travelType'],
            'distance' => $formData['distance'],
            'created_at' => Carbon::now(),
        ]);

        foreach ($places as $place) {

            Result::create([
                'searches_id' => $search->id,
                'place_name' => $place['name'] ?? null,
                'address' => $place['address'] ?? null,
                'lat' => $place['lat'] ?? null,
                'lng' => $place['lng'] ?? null,
                'distance' => $place['distance'] ?? null,
                'description' => $place['description'] ?? null,
                'rating' => $place['rating'] ?? null,
                'created_at' => Carbon::now(),
            ]);
        }
    }
}
