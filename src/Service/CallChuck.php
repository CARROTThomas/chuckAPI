<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class CallChuck
{
    public function __construct(
        private HttpClientInterface $client,
    ) {
    }

    public function fetchChuckNorris(): array
    {
        $response = $this->client->request(
            'GET',
            'https://api.chucknorris.io/jokes/random'
        );

      //  $statusCode = $response->getStatusCode();
        // $statusCode = 200
      //  $contentType = $response->getHeaders()['content-type'][0];
        // $contentType = 'application/json'
      //  $content = $response->getContent();
        // $content = '{"id":521583, "name":"symfony-docs", ...}'
        $content = $response->toArray();
        // $content = ['id' => 521583, 'name' => 'symfony-docs', ...]

        return $content;
    }
}