<?php

namespace App\Services\Ai;

use Illuminate\Support\Facades\Http;

class GeminiService
{
    public function generate(array $places): array
    {
        $prompt = $this->buildPrompt($places);

        $response = Http::timeout(60)->post(
            'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash-lite:generateContent?key='
                . env('GEMINI_API_KEY'),
            [
                'contents' => [[
                    'parts' => [[
                        'text' => $prompt
                    ]]
                ]]
            ]
        );

        if (!$response->successful()) {
            throw new \Exception(
                'Gemini request failed: ' . $response->status() . ' ' . $response->body()
            );
        }


        return $this->parse($response->json());
    }

    private function buildPrompt(array $places): string
    {
        return "
You are a virtual tourist guide and analytical assistant specializing in describing tourist destinations and places for leisure.

You are provided with a list of places in JSON format:

"
            . json_encode($places, JSON_UNESCAPED_UNICODE)
            . "

For each place, create a detailed but concise tourist-oriented description.

The description must contain approximately 4-5 sentences and should explain:

1. What kind of place it is and what its main purpose or character is.
2. What a visitor can generally do or experience there, but only when this can be reasonably determined from the available information.
3. What type of leisure or travel this place is suitable for, for example:
   - active recreation
   - relaxation
   - sightseeing
   - cultural tourism
   - nature tourism
   - gastronomic tourism
   - city tourism
   - family recreation
4. Explain why the place may be suitable for the corresponding type of recreation.
5. Provide useful context that helps a tourist understand what kind of experience they can expect.

The description should sound natural and informative, like a recommendation from a professional tourist guide.

IMPORTANT CONSTRAINTS:

- Do NOT invent specific facts about the place.
- Do NOT invent opening hours, prices, historical dates, attractions, services, facilities, events, reviews, or other details that are not supported by the provided data.
- Do NOT claim that a place definitely offers a specific service unless this can be determined from the available information.
- You may use the place name, address, category, and other information provided in the input to determine the general type and purpose of the place.
- If the available information is insufficient to describe the place reliably, provide a general description based only on the available information.
- Do not make unsupported claims or assumptions.
- Avoid repeating the same information in different sentences.

RATING:

Assign a rating from 0.0 to 5.0 with one decimal precision.

The rating should represent how well the place appears to match its general purpose and the requested type of recreation based on the available information.

If there is not enough information to reasonably evaluate the place, return null.

OUTPUT REQUIREMENTS:

- Return ONLY a valid JSON array.
- Do not include Markdown.
- Do not include code blocks.
- Do not include explanations before or after the JSON.
- Each item must follow exactly this structure:

{
    \"id\": number,
    \"description\": string,
    \"rating\": number|null
}

EXAMPLE OUTPUT:

[
    {
        \"id\": 1,
        \"description\": \"This is a natural recreation area located near the searched location. The place is suitable for spending time outdoors and enjoying the surrounding natural environment. It can be a good choice for nature tourism and a more active form of recreation, especially for visitors who want to spend time away from urban areas. Its character makes it suitable for people looking for outdoor activities and contact with nature.\",
        \"rating\": 4.3
    }
]

Begin processing the list now.
";
    }

    private function parse(array $data): array
    {
        $text = $data['candidates'][0]['content']['parts'][0]['text'] ?? '';

        $clean = preg_replace('/```json|```/', '', $text);

        $decoded = json_decode(trim($clean), true);

        if ($decoded !== null) {
            return $decoded;
        }

        preg_match('/\[\s*{.*}\s*\]/s', $clean, $m);

        return json_decode($m[0] ?? '[]', true);
    }
}
