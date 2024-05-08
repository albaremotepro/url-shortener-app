<?php

namespace App\Services;

use GuzzleHttp\Client;

class GoogleSafeBrowsingService
{
    protected $client;
    protected $apiKey;

    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = config('services.safebrowsing.apiKey');
    }

    public function checkUrl($url)
    {
        $endpoint = 'https://safebrowsing.googleapis.com/v4/threatMatches:find';
        $body = [
            'client' => [
                'clientId'      => $this->apiKey,
                'clientVersion' => '1.5.2'
            ],
            'threatInfo' => [
                'threatTypes'      => ['MALWARE', 'SOCIAL_ENGINEERING'],
                'platformTypes'    => ['ANY_PLATFORM'],
                'threatEntryTypes' => ['URL'],
                'threatEntries'    => [
                    ['url' => $url]
                ]
            ]
        ];

        try {
            $response = $this->client->post($endpoint, [
                'json' => $body,
                'query' => [
                    'key' => $this->apiKey
                ]
            ]);

            $data = json_decode($response->getBody(), true);

            // Check if the response contains any matches
            return empty($data['matches']);
        } catch (\Exception $e) {
            return false;
        }
    }
}
