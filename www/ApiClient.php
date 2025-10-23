<?php
require_once __DIR__ . '/vendor/autoload.php';
use GuzzleHttp\Client;

class ApiClient {
    private Client $client;

    public function __construct() {
        $this->client = new Client();
    }

    public function request(string $url): array {
        try {
            $response = $this->client->get($url);
            $body = $response->getBody()->getContents();
            return json_decode($body, true);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    
    public function getSpaceNews(): array {
        $url = 'https://api.spaceflightnewsapi.net/v4/articles/';
        return $this->request($url);
    }

    // Метод для получения случайной новости
    public function getRandomArticle(): array {
        $data = $this->getSpaceNews();
        
        if (isset($data['error'])) {
            return $data;
        }

        if (isset($data['results']) && count($data['results']) > 0) {
            $randomIndex = array_rand($data['results']);
            return $data['results'][$randomIndex];
        }

        return ['error' => 'No articles found'];
    }
}
?>