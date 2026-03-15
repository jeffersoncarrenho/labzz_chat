<?php

namespace App\Services;

use Elastic\Elasticsearch\ClientBuilder;

class SearchService
{
    protected $client;

    public function __construct()
    {
        $this->client = ClientBuilder::create()
            ->setHosts(['http://localhost:9200'])
            ->build();
    }

    public function indexMessage($message)
    {
        $params = [
            'index' => 'messages',
            'id' => $message->id,
            'body' => [
                'content' => $message->content,
                'conversation_id' => $message->conversation_id,
                'user_id' => $message->user_id,
                'created_at' => $message->created_at
            ]
        ];

        return $this->client->index($params);
    }

    public function searchMessages($query)
    {
        $params = [
            'index' => 'messages',
            'body' => [
                'query' => [
                    'match' => [
                        'content' => $query
                    ]
                ]
            ]
        ];

        return $this->client->search($params);
    }
}
