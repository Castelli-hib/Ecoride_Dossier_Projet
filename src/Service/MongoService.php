<?php
namespace App\Service;

use MongoDB\Client;

class MongoService
{
    private Client $client;

    public function __construct(string $mongoUri)
    {
        $this->client = new Client($mongoUri);
    }

    public function getCollection(string $db, string $collection)
    {
        return $this->client->$db->$collection;
    }

    public function insertDocument(string $db, string $collection, array $document)
    {
        return $this->client->$db->$collection->insertOne($document);
    }

    public function findDocuments(string $db, string $collection, array $filter = [])
    {
        return $this->client->$db->$collection->find($filter)->toArray();
    }
}