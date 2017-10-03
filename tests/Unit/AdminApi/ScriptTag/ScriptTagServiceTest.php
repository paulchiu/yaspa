<?php

namespace Yaspa\Tests\Unit\AdminApi\ScriptTag;

use GuzzleHttp\Client;
use Yaspa\AdminApi\ScriptTag\Builders\CountScriptTagsRequest;
use Yaspa\AdminApi\ScriptTag\Builders\GetScriptTagsRequest;
use Yaspa\AdminApi\ScriptTag\Builders\ModifyExistingScriptTagRequest;
use Yaspa\AdminApi\ScriptTag\Models\ScriptTag;
use Yaspa\AdminApi\ScriptTag\ScriptTagService;
use Yaspa\Authentication\Factory\ApiCredentials;
use PHPUnit\Framework\TestCase;
use Yaspa\Factory;
use Yaspa\Tests\Utils\MockGuzzleClient;

class ScriptTagServiceTest extends TestCase
{
    public function testCanCreateScriptTag()
    {
        // Create mock client
        $mockClientUtil = new MockGuzzleClient();
        $client = $mockClientUtil->makeWithJsonResponse(200, [
                'script_tag' => [
                    'id' => 3,
                    'src' => 'https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.0/moment.js',
                    'event' => 'onload',
                ],
            ]
        );
        Factory::inject(Client::class, $client);

        // Create parameters
        $scriptTag = (new ScriptTag())
            ->setSrc('https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.0/moment.js')
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
                        [
                            'id'  => 3,
                            'src' => 'https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.0/moment.js',
                            'event' => 'onload',
                        ],
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
            ->withCredentials($credentials);

        // Test method
        $service = Factory::make(ScriptTagService::class);
        $scriptTags = $service->getScriptTags($request);
        $this->assertTrue(is_iterable($scriptTags));
        foreach ($scriptTags as $scriptTag) {
            $this->assertInstanceOf(ScriptTag::class, $scriptTag);
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
        $service = Factory::make(ScriptTagService::class);
        $scriptTagCount = $service->countScriptTags($request);
        $this->assertEquals(3, $scriptTagCount);
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
                        'src' => 'https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.0/moment.js',
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
        $this->assertEquals(3, $scriptTag->getId());
        $this->assertEquals('https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.0/moment.js', $scriptTag->getSrc());
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
                        'src' => 'https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.0/moment.js',
                        'event' => 'onload',
                    ],
                ]),
            ]
        );
        Factory::inject(Client::class, $client);

        // Create parameters
        $scriptTag = (new ScriptTag())
            ->setSrc('https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.0/moment.js')
            ->setEvent('onload');
        $credentials = Factory::make(ApiCredentials::class)
            ->makeOAuth('foo', 'bar');
        $request = Factory::make(ModifyExistingScriptTagRequest::class)
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
