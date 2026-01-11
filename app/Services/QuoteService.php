<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;

class QuoteService
{
    protected $client;
    protected $apiUrl = 'https://quotes.liupurnomo.com/api/quotes/random';

    public function __construct()
    {
        $this->client = new Client([
            'timeout' => 10,
            'verify' => false, // untuk development
        ]);
    }

    public function getRandomQuote()
    {
        try {
            // Cache quote selama 1 menit untuk mengurangi request (API limit 60 req/min)
            return Cache::remember('random_quote', 60, function () {
                $response = $this->client->get($this->apiUrl);
                $data = json_decode($response->getBody()->getContents(), true);

                // Format response sesuai API: {status, message, data: {text, author, category, id}}
                if (isset($data['data'])) {
                    return [
                        'quote' => $data['data']['text'] ?? 'Berusahalah dengan keras untuk mencapai tujuanmu.',
                        'author' => $data['data']['author'] ?? 'Unknown',
                        'category' => $data['data']['category'] ?? null,
                        'id' => $data['data']['id'] ?? null,
                    ];
                }

                // Fallback jika format response berbeda
                return [
                    'quote' => 'Berusahalah dengan keras untuk mencapai tujuanmu.',
                    'author' => 'Unknown',
                    'category' => null,
                    'id' => null,
                ];
            });
        } catch (\Exception $e) {
            // Fallback quote jika API gagal
            return [
                'quote' => 'Kesuksesan adalah hasil dari persiapan, kerja keras, dan belajar dari kegagalan.',
                'author' => 'Colin Powell',
                'category' => null,
                'id' => null,
            ];
        }
    }

    public function clearCache()
    {
        Cache::forget('random_quote');
    }
}
