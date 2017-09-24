<?php

namespace Yaspa\Tests\Unit\AdminApi\ScriptTag;

use DateTime;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use Yaspa\AdminApi\ScriptTag\Builders\GetScriptTagsRequest;
use Yaspa\AdminApi\ScriptTag\Models\ScriptTag;
use Yaspa\AdminApi\ScriptTag\ScriptTagService;
use Yaspa\Authentication\Factory\ApiCredentials;
use Yaspa\Factory;
use Yaspa\Tests\Utils\MockGuzzleClient;

class ScriptTagServiceTest extends TestCase
{

    public function testCanCreateScriptTag()
    {
        // Create mock client
        $mockClientUtil = new MockGuzzleClient();
        $client = $mockClientUtil->makeWithResponses(
            [
                $mockClientUtil->makeWithJsonResponse(200, [
                    'script_tag' => [
                        'id' => 3,
                        'src' => 'https:\/\/djavaskripped.org\/fancy.js',
                        'event' => 'onload',
                    ],
                ]),
            ]
        );
        Factory::inject(Client::class, $client);

        // Create parameters
        $scriptTag = (new ScriptTag())->setSrc('https:\/\/djavaskripped.org\/fancy.js')
            ->setEvent('onload');
        $credentials = Factory::make(ApiCredentials::class)
            ->makeOAuth('foo', 'bar');

        // Test method
        $service = Factory::make(ScriptTagService::class);
        $newScriptTag = $service->createNewScriptTag($credentials, $scriptTag);
        $this->assertInstanceOf(ScriptTag::class, $newScriptTag);
    }

    public function testCanGetScriptTags()
    {
        // Create mock client
        $mockClientUtil = new MockGuzzleClient();
        $client = $mockClientUtil->makeWithResponses(
            [
                $mockClientUtil->makeJsonResponse(200, [
                    'script_tags' => [
                        'id'  => 3,
                        'src' => 'https:\/\/djavaskripped.org\/fancy.js',
                        'event' => 'onload',
                    ],
                ]),
                $mockClientUtil->makeJsonResponse(200, [
                    'script_tags' => [],
                ]),
            ]
        );
        Factory::inject(Client::class, $client, 2);

        // Create parameters
        $credentials = Factory::make(ApiCredentials::class)
            ->makeOAuth('foo', 'bar');
        $request = Factory::make(GetScriptTagsRequest::class)
            ->withCreadentials($credentials);

        // Test method
        $service = Factory::make(GetScriptTagsRequest::class);
        $scriptTags = $service->getScriptTags($request);
        $this->assetTrue(is_iterable($scriptTags));
        foreach ($scriptTags as $scriptTag) {
            $this->assertInstanceOf(ScriptTags::class, $scriptTag);
            $this->assertNotEmpty($scriptTag->getId());
        }
    }

    public function testCanCountScriptTags()
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
        $request = Factory::make(CountScriptTagsRequest::class)
            ->withCredentials($credentials);

        // Test method
        $service = Factory::make(ScriptTagsService::class);
        $scriptTagsCount = $service->countScriptTags($request);
        $this->assertEquals(3, $scriptTagsCount);
    }

    public function testCanGetScriptTagById()
    {
        // Create mock client
        $mockClientUtil = new MockGuzzleClient();
        $client = $mockClientUtil->makeWithResponses(
            [
                $mockClientUtil->makeJsonResponse(200, [
                    'script_tag' => [
                        'id' => 3,
                        'src' => 'https:\/\/djavaskripped.org\/fancy.js',
                        'event' => 'onload',
                    ],
                ]),
            ]
        );
        Factory::inject(Client::class, $client);

        // Create parameters
        $credentials = Factory::make(ApiCredentials::class)
            ->makeOAuth('foo', 'bar');

        // Test method
        $service = Factory::make(ScriptTagService::class);
        $scriptTag = $service->getScriptTag($credentials, 3);
        $this->assertEquals('https:\/\/djavaskripped.org\/fancy.js', $scriptTag->getSrc());
        $this->assertEquals('onload', $scriptTag->getEvent());
    }

    public function testCanUpdateAScriptTag()
    {
        // Create mock client
        $mockClientUtil = new MockGuzzleClient();
        $client = $mockClientUtil->makeWithResponses(
            [
                $mockClientUtil->makeJsonResponse(200, [
                    'script_tag' => [
                        'id' => 3,
                        'title' => 'foo',
                    ],
                ]),
            ]
        );
        Factory::inject(Client::class, $client);

        // Create parameters
        $scriptTag = (new ScriptTag())->setSrc('https:\/\/djavaskripped.org\/fancy.js')
            ->setEvent('onload');
        $credentials = Factory::make(ApiCredentials::class)
            ->makeOAuth('foo', 'bar');
        $request = Factory::make(ModifyScriptTagRequest::class)
            ->withCredentials($credentials)
            ->withScriptTag($scriptTag);

        // Test method
        $service = Factory::make(ScriptTagService::class);
        $updatedScriptTag = $service->modifyExistingScriptTag($request);
        $this->assertInstanceOf(ScriptTag::class, $updatedScriptTag);
    }

    public function testCanDeleteScriptTag()
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
        $service = Factory::make(ScriptTagService::class);
        $result = $service->deleteScriptTag($credentials, 3);

        // Test results
        $this->assertTrue(is_object($result));
        $this->assertEmpty(get_object_vars($result));
    }
}
