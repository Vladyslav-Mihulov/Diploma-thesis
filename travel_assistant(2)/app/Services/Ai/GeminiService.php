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
You are a virtual tourist guide and analytical assistant specializing in describing tourist locations.

You are provided with a list of places in JSON format:

"
            . json_encode($places, JSON_UNESCAPED_UNICODE)
            . "

For each place in the list, you must generate:

1. A short description (exactly 2 sentences)
2. A rating (a number from 0 to 5 with one decimal precision)

---

    IMPORTANT CONSTRAINTS:
- Do NOT invent or hallucinate any information.
- Use only publicly available, verified, and reliable data sources.
- If sufficient verified information is not available, return:
  - description: \"No verified information available\"
  - rating: null
- Do not include assumptions, guesses, or subjective opinions without evidence.

---

    OUTPUT REQUIREMENTS:
- Return ONLY a valid JSON array
- No explanations, comments, or additional text
- Each item must follow this structure:

{
  \"id\": number,
  \"description\": string,
  \"rating\": number|null
}

---

    EXAMPLE OUTPUT:

[
  {
    \"id\": 1,
    \"description\": \"... ...\",
    \"rating\": 4.5
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
