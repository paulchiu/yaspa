<?php

namespace Yaspa\Tests\Unit\AdminApi\Product;

use GuzzleHttp\Client;
use Yaspa\AdminApi\Product\Builders\GetProductsRequest;
use Yaspa\AdminApi\Product\Models\Product;
use Yaspa\AdminApi\Product\ProductService;
use PHPUnit\Framework\TestCase;
use Yaspa\Authentication\Factory\ApiCredentials;
use Yaspa\Factory;
use Yaspa\Tests\Utils\MockGuzzleClient;

class ProductServiceTest extends TestCase
{
    public function testCanCreateNewProduct()
    {
        // Create mock client
        $mockClientUtil = new MockGuzzleClient();
        $client = $mockClientUtil->makeWithResponses(
            [
                $mockClientUtil->makeJsonResponse(200, [
                    'product' => [
                        'id' => 3,
                        'title' => 'foo',
                    ],
                ]),
            ]
        );
        Factory::inject(Client::class, $client);

        // Create parameters
        $product = (new Product())->setTitle('foo');
        $credentials = Factory::make(ApiCredentials::class)
            ->makeOAuth('foo', 'bar');

        // Test method
        /** @var ProductService $service */
        $service = Factory::make(ProductService::class);
        $newProduct = $service->createNewProduct($credentials, $product);
        $this->assertInstanceOf(Product::class, $newProduct);
    }

    public function testCanGetProducts()
    {
        // Create mock client
        $mockClientUtil = new MockGuzzleClient();
        $client = $mockClientUtil->makeWithResponses(
            [
                $mockClientUtil->makeJsonResponse(200, [
                    'products' => [
                        [
                            'id' => 3,
                            'title' => 'foo',
                        ],
                    ],
                ]),
                $mockClientUtil->makeJsonResponse(200, [
                    'products' => [],
                ]),
            ]
        );
        Factory::inject(Client::class, $client, 2);

        // Create parameters
        $credentials = Factory::make(ApiCredentials::class)
            ->makeOAuth('foo', 'bar');
        $request = Factory::make(GetProductsRequest::class)
            ->withCredentials($credentials);

        // Test method
        /** @var ProductService $service */
        $service = Factory::make(ProductService::class);
        $products = $service->getProducts($request);
        $this->assertTrue(is_iterable($products));
        foreach ($products as $product) {
            $this->assertInstanceOf(Product::class, $product);
            $this->assertNotEmpty($product->getId());
        }
    }
}
