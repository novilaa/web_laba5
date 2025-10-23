<?php
require_once __DIR__ . '/vendor/autoload.php';
use GuzzleHttp\Client;

class ApiClient {
    private Client $client;

    public function __construct() {
        $this->client = new Client();
    }

    public function getSpaceNews(): array {
        $url = 'https://api.spaceflightnewsapi.net/v4/articles/';
        try {
            $response = $this->client->get($url);
            $body = $response->getBody()->getContents();
            return json_decode($body, true);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
?>