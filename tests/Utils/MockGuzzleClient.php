<?php

namespace Yaspa\Tests\Utils;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;

class MockGuzzleClient
{
    /**
     * Creates a Guzzle client with middlewares that return a mocked response
     * as well as tracks requests.
     *
     * @see http://docs.guzzlephp.org/en/stable/testing.html
     * @param int $responseStatus
     * @param array $responseData
     * @param array $historyContainer
     * @return Client
     */
    public function makeWithJsonResponse(
        int $responseStatus,
        array $responseData,
        array &$historyContainer = []
    ): Client {
        $mock = new MockHandler([
            new Response(
                $responseStatus,
                [],
                json_encode($responseData)
            ),
        ]);
        $stack = HandlerStack::create($mock);
        $history = Middleware::history($historyContainer);
        $stack->push($history);
        $client = new Client(['handler' => $stack]);

        return $client;
    }
}
