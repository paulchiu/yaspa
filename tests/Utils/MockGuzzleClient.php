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
     * This is a convenience wrapper for self::makeWithResponses
     *
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
        $response = self::makeJsonResponse($responseStatus, $responseData);

        return self::makeWithResponses([$response], $historyContainer);
    }

    /**
     * Make a PSR response convenience method.
     *
     * @param int $responseStatus
     * @param array $responseData
     * @return Response
     */
    public function makeJsonResponse(int $responseStatus, array $responseData): Response
    {
        return new Response($responseStatus, [], json_encode($responseData));
    }

    /**
     * Creates a Guzzle client with middlewares that return an array of mocked responses
     * as well as tracks requests.
     *
     * @see http://docs.guzzlephp.org/en/stable/testing.html
     * @param array $responses
     * @param array $historyContainer
     * @return Client
     */
    public function makeWithResponses(array $responses, array &$historyContainer = [])
    {
        $mock = new MockHandler($responses);
        $stack = HandlerStack::create($mock);
        $history = Middleware::history($historyContainer);
        $stack->push($history);
        $client = new Client(['handler' => $stack]);

        return $client;
    }
}
