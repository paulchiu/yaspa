<?php

namespace Yaspa\Tests\Unit\AdminApi\Redirect;

use GuzzleHttp\Client;
use Yaspa\AdminApi\Redirect\Builders\CountAllRedirectsRequest;
use Yaspa\AdminApi\Redirect\Builders\GetRedirectsRequest;
use Yaspa\AdminApi\Redirect\Builders\ModifyExistingRedirectRequest;
use Yaspa\AdminApi\Redirect\Models\Redirect;
use Yaspa\AdminApi\Redirect\RedirectService;
use Yaspa\Authentication\Factory\ApiCredentials;
use PHPUnit\Framework\TestCase;
use Yaspa\Factory;
use Yaspa\Tests\Utils\MockGuzzleClient;

class RedirectServiceTest extends TestCase
{
    public function testCanCreateRedirect()
    {
        // Create mock client
        $mockClientUtil = new MockGuzzleClient();
        $client = $mockClientUtil->makeWithJsonResponse(200, [
                'redirect' => [
                    'id' => 3,
                    'path' => '/foo',
                    'target' => '/bar',
                ],
            ]
        );
        Factory::inject(Client::class, $client);

        // Create parameters
        $redirect = (new Redirect())
            ->setPath(uniqid('/ipod-'))
            ->setTarget('/pages/itunes');
        $credentials = Factory::make(ApiCredentials::class)
            ->makeOAuth('foo', 'bar');

        // Test method
        $service = Factory::make(RedirectService::class);
        $newRedirect = $service->createNewRedirect($credentials, $redirect);
        $this->assertInstanceOf(Redirect::class, $newRedirect);
    }

    public function testCanGetRedirects()
    {
        // Create mock client
        $mockClientUtil = new MockGuzzleClient();
        $client = $mockClientUtil->makeWithResponses(
            [
                $mockClientUtil->makeJsonResponse(200, [
                    'redirects' => [
                        [
                            'id'  => 3,
                            'path' => '/foo',
                            'target' => '/bar',
                        ],
                    ],
                ]),
                $mockClientUtil->makeJsonResponse(200, [
                    'redirects' => [],
                ]),
            ]
        );
        Factory::inject(Client::class, $client, 2);

        // Create parameters
        $credentials = Factory::make(ApiCredentials::class)
            ->makeOAuth('foo', 'bar');
        $request = Factory::make(GetRedirectsRequest::class)
            ->withCredentials($credentials);

        // Test method
        $service = Factory::make(RedirectService::class);
        $redirects = $service->getRedirects($request);
        $this->assertTrue(is_iterable($redirects));
        foreach ($redirects as $redirect) {
            $this->assertInstanceOf(Redirect::class, $redirect);
            $this->assertNotEmpty($redirect->getId());
        }
    }

    public function testCanCountRedirects()
    {
        // Create mock client
        $mockClientUtil = new MockGuzzleClient();
        $client = $mockClientUtil->makeWithResponses(
            [
                $mockClientUtil->makeJsonResponse(200, [
                    'count' => 3,
                ]),
            ]
        );
        Factory::inject(Client::class, $client);

        // Create parameters
        $credentials = Factory::make(ApiCredentials::class)
            ->makeOAuth('foo', 'bar');
        $request = Factory::make(CountAllRedirectsRequest::class)
            ->withCredentials($credentials);

        // Test method
        $service = Factory::make(RedirectService::class);
        $redirectCount = $service->countRedirects($request);
        $this->assertEquals(3, $redirectCount);
    }

    public function testCanGetRedirectById()
    {
        // Create mock client
        $mockClientUtil = new MockGuzzleClient();
        $client = $mockClientUtil->makeWithResponses(
            [
                $mockClientUtil->makeJsonResponse(200, [
                    'redirect' => [
                        'id' => 3,
                        'path' => '/foo',
                        'target' => '/bar',
                    ],
                ]),
            ]
        );
        Factory::inject(Client::class, $client);

        // Create parameters
        $credentials = Factory::make(ApiCredentials::class)
            ->makeOAuth('foo', 'bar');

        // Test method
        $service = Factory::make(RedirectService::class);
        $redirect = $service->getRedirectById($credentials, 3);
        $this->assertEquals(3, $redirect->getId());
        $this->assertEquals('/foo', $redirect->getPath());
        $this->assertEquals('/bar', $redirect->getTarget());
    }

    public function testCanUpdateARedirect()
    {
        // Create mock client
        $mockClientUtil = new MockGuzzleClient();
        $client = $mockClientUtil->makeWithResponses(
            [
                $mockClientUtil->makeJsonResponse(200, [
                    'redirect' => [
                        'id' => 3,
                        'path' => '/foo',
                        'target' => '/bar',
                    ],
                ]),
            ]
        );
        Factory::inject(Client::class, $client);

        // Create parameters
        $redirect = (new Redirect())
            ->setId(3)
            ->setTarget('/baz');
        $credentials = Factory::make(ApiCredentials::class)
            ->makeOAuth('foo', 'bar');
        $request = Factory::make(ModifyExistingRedirectRequest::class)
            ->withCredentials($credentials)
            ->withRedirect($redirect);

        // Test method
        $service = Factory::make(RedirectService::class);
        $updatedRedirect = $service->modifyExistingRedirect($request);
        $this->assertInstanceOf(Redirect::class, $updatedRedirect);
    }

    public function testCanDeleteRedirect()
    {
        // Create mock client
        $mockClientUtil = new MockGuzzleClient();
        $client = $mockClientUtil->makeWithResponses(
            [
                $mockClientUtil->makeEmptyJsonResponse(200),
            ]
        );
        Factory::inject(Client::class, $client);

        // Create parameters
        $credentials = Factory::make(ApiCredentials::class)
            ->makeOAuth('foo', 'bar');

        // Test service method
        $service = Factory::make(RedirectService::class);
        $result = $service->deleteRedirectById($credentials, 3);

        // Test results
        $this->assertTrue(is_object($result));
        $this->assertEmpty(get_object_vars($result));
    }
}
