<?php

namespace Yaspa\Tests\OAuth;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Middleware;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Yaspa\Authentication\OAuth\ConfirmInstallation;
use Yaspa\Factory;
use Yaspa\Models\Authentication\OAuth\AccessToken;
use Yaspa\Models\Authentication\OAuth\ConfirmationRedirect;
use Yaspa\Models\Authentication\OAuth\Credentials;

class ConfirmInstallationTest extends TestCase
{
    public function testCanRequestPermanentAccessToken()
    {
        // Create mock client
        $mock = new MockHandler([
            new Response(
                200,
                [],
                json_encode([
                    'access_token' => 'foo',
                ])
            ),
        ]);
        $stack = HandlerStack::create($mock);
        $container = [];
        $history = Middleware::history($container);
        $stack->push($history);
        $client = new Client(['handler' => $stack]);
        Factory::inject(Client::class, $client);

        // Create parameters
        $confirmation = new ConfirmationRedirect();
        $confirmation
            ->setCode('0907a61c0c8d55e99db179b68161bc00')
            ->setShop('some-shop.myshopify.com')
            ->setTimestamp('1337178173')
            ->setHmac('4712bf92ffc2917d15a2f5a273e39f0116667419aa4b6ac0b3baaf26fa3c4d20');

        $credentials = new Credentials();
        $credentials->setApiSecretKey('hush');

        // Test method
        $confirmInstallation = Factory::make(ConfirmInstallation::class);
        $result = $confirmInstallation->requestPermanentAccessToken($confirmation, $credentials);
        $this->assertInstanceOf(AccessToken::class, $result);
        $this->assertEquals('foo', $result->getAccessToken());
    }

    public function testCanAsyncRequestPermanentAccessToken()
    {
        // Create mock client
        $mock = new MockHandler([
            new Response(200),
        ]);
        $stack = HandlerStack::create($mock);
        $container = [];
        $history = Middleware::history($container);
        $stack->push($history);
        $client = new Client(['handler' => $stack]);
        Factory::inject(Client::class, $client);

        // Create parameters
        $confirmation = new ConfirmationRedirect();
        $confirmation
            ->setCode('0907a61c0c8d55e99db179b68161bc00')
            ->setShop('some-shop.myshopify.com')
            ->setTimestamp('1337178173')
            ->setHmac('4712bf92ffc2917d15a2f5a273e39f0116667419aa4b6ac0b3baaf26fa3c4d20');

        $credentials = new Credentials();
        $credentials->setApiSecretKey('hush');

        // Test method
        $confirmInstallation = Factory::make(ConfirmInstallation::class);
        $result = $confirmInstallation->asyncRequestPermanentAccessToken($confirmation, $credentials);
        $result->wait();
        $this->assertInstanceOf(PromiseInterface::class, $result);
        $this->assertCount(1, $container);
        /** @var RequestInterface $request */
        $request = $container[0]['request'];
        $requestBody = $request->getBody()->getContents();
        $this->assertContains('client_id', $requestBody);
        $this->assertContains('client_secret', $requestBody);
        $this->assertContains('code', $requestBody);
    }
}
