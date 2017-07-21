<?php

namespace Yaspa\Tests\Unit\Authentication\OAuth;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Yaspa\Authentication\OAuth\DelegateAccess;
use Yaspa\Authentication\OAuth\Scopes;
use Yaspa\Factory;
use Yaspa\Models\Authentication\OAuth\AccessToken;

class DelegateAccessTest extends TestCase
{
    public function testCanDelegateAccessToken()
    {
        // Create mock client
        $mock = new MockHandler([
            new Response(
                200,
                [],
                json_encode([
                    'access_token' => 'foo',
                    'scope' => 'bar,baz',
                    'expires_in' => 10,
                ])
            ),
        ]);
        $stack = HandlerStack::create($mock);
        $container = [];
        $history = Middleware::history($container);
        $stack->push($history);
        $client = new Client(['handler' => $stack]);
        Factory::inject(Client::class, $client);

        // Prepare parameters
        $accessToken = new AccessToken();
        $accessToken->setAccessToken('foo');

        $scopes = (new Scopes())
            ->withWriteOrders()
            ->withWriteCustomers();

        // Test method
        $instance = Factory::make(DelegateAccess::class);
        $delegateToken = $instance->createNewDelegateAccessToken(
            'bar',
            $accessToken,
            $scopes,
            10
        );
        $this->assertInstanceOf(AccessToken::class, $delegateToken);
        $this->assertNotEmpty($delegateToken->getAccessToken());
        $this->assertNotEmpty($delegateToken->getScopes());
        $this->assertNotEmpty($delegateToken->getExpiresIn());

        // Test request
        $this->assertCount(1, $container);
        /** @var RequestInterface $request */
        $request = $container[0]['request'];
        $requestBody = $request->getBody()->getContents();
        $this->assertContains('delegate_access_scope', $requestBody);
        $this->assertContains('expires_in', $requestBody);
    }

    public function testCanDelegateAccessTokenWithoutExpires()
    {
        // Create mock client
        $mock = new MockHandler([
            new Response(
                200,
                [],
                json_encode([
                    'access_token' => 'foo',
                    'scope' => 'bar,baz',
                ])
            ),
        ]);
        $stack = HandlerStack::create($mock);
        $container = [];
        $history = Middleware::history($container);
        $stack->push($history);
        $client = new Client(['handler' => $stack]);
        Factory::inject(Client::class, $client);

        // Prepare parameters
        $accessToken = new AccessToken();
        $accessToken->setAccessToken('foo');

        $scopes = (new Scopes())
            ->withWriteOrders()
            ->withWriteCustomers();

        // Test method
        $instance = Factory::make(DelegateAccess::class);
        $delegateToken = $instance->createNewDelegateAccessToken(
            'bar',
            $accessToken,
            $scopes
        );
        $this->assertInstanceOf(AccessToken::class, $delegateToken);
        $this->assertNotEmpty($delegateToken->getAccessToken());
        $this->assertNotEmpty($delegateToken->getScopes());
        $this->assertEmpty($delegateToken->getExpiresIn());

        // Test request
        $this->assertCount(1, $container);
        /** @var RequestInterface $request */
        $request = $container[0]['request'];
        $requestBody = $request->getBody()->getContents();
        $this->assertContains('delegate_access_scope', $requestBody);
        $this->assertNotContains('expires_in', $requestBody);
    }
}
