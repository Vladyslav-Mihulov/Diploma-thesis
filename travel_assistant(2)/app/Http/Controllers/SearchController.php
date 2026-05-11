<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRequest;
use App\Services\Search\SearchService;

class SearchController extends Controller
{
    public function __construct(
        protected SearchService $searchService
    ) {}

    public function show()
    {
        return view('search.search');
    }

    public function submit(SearchRequest $request)
    {
        $formData = [
            'address' => $request->input('address_address-search'),
            'city' => $request->input('city'),
            'state' => $request->input('state'),
            'postcode' => $request->input('postcode'),
        ];
        $result = $this->searchService->handle($request);

        if (isset($result['error'])) {
            return redirect()
                ->route('search')
                ->withErrors([
                    'address' => $result['error']
                ]);
        }

        return view('search.search-results', [
            'places' => $result['places'],
            'resolved_address' => $result['resolved_address'],
            'coordinates' => $result['coordinates'],
            'formData' => $formData,
        ]);
    }
}
