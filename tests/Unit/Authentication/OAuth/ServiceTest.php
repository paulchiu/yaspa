<?php

namespace Yaspa\Tests\Unit\Authentication\OAuth;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Yaspa\Authentication\OAuth\Builder\Scopes;
use Yaspa\Authentication\OAuth\Models\AccessToken;
use Yaspa\Authentication\OAuth\Models\ConfirmationRedirect;
use Yaspa\Authentication\OAuth\Models\Credentials;
use Yaspa\Authentication\OAuth\Service as OAuthService;
use Yaspa\Factory;

class ServiceTest extends TestCase
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

        // Test results
        $oAuthService = Factory::make(OAuthService::class);
        $result = $oAuthService->requestPermanentAccessToken($confirmation, $credentials);
        $this->assertInstanceOf(AccessToken::class, $result);
        $this->assertEquals('foo', $result->getAccessToken());

        // Test request
        $this->assertCount(1, $container);
        /** @var RequestInterface $request */
        $request = $container[0]['request'];
        $requestBody = $request->getBody()->getContents();
        $this->assertContains('client_id', $requestBody);
        $this->assertContains('client_secret', $requestBody);
        $this->assertContains('code', $requestBody);
    }

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
        $instance = Factory::make(OAuthService::class);
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
        $instance = Factory::make(OAuthService::class);
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
