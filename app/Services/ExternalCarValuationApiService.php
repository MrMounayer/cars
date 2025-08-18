<?php

namespace App\Services;


use Exception;
use Illuminate\Support\Facades\Http;

class ExternalCarValuationApiService
{
    /**
     * Attempt to get car valuation from an external API.
     * Throws on failure.
     */
    public function getValuation($make, $model, $year, $mileage = null)
    {
        // Use OpenAI ChatGPT API for valuation
        $apiKey = env('OPENAI_API_KEY');
        if (!$apiKey) {
            throw new Exception('OpenAI API key not set in environment.');
        }

        $prompt = "Estimate the minimum and maximum market value in USD for a $year $make $model with $mileage miles. Respond in JSON: {\"min\": <min>, \"max\": <max>}";

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiKey,
            'Content-Type' => 'application/json',
        ])->post('https://api.openai.com/v1/chat/completions', [
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                ['role' => 'system', 'content' => 'You are a helpful assistant for car price estimation.'],
                ['role' => 'user', 'content' => $prompt],
            ],
            'max_tokens' => 100,
        ]);

        if (!$response->successful()) {
            throw new Exception('OpenAI API error: ' . $response->body());
        }

        $choices = $response->json('choices');
        if (!$choices || !isset($choices[0]['message']['content'])) {
            throw new Exception('Invalid response from OpenAI API.');
        }

        $content = $choices[0]['message']['content'];
        $json = json_decode($content, true);
        if (is_array($json) && isset($json['min'], $json['max'])) {
            return [
                'min' => $json['min'] *35.35,
                'max' => $json['max']* 35.35,
            ];
        }
        throw new Exception('Could not parse valuation from ChatGPT response: ' . $content);
    }
}
