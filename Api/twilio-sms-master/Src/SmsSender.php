<?php declare(strict_types=1);

namespace App;

use Twilio\Rest\Client;

class SmsSender
{

    /**
     * @var Client
     */
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function __invoke(string $toNumber, array $payload): void
    {
        $this->client->messages->create($toNumber, $payload);
    }
}
