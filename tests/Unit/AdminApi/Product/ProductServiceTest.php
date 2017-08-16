<?php

namespace Yaspa\Tests\Unit\AdminApi\Product;

use GuzzleHttp\Client;
use Yaspa\AdminApi\Product\Builders\CountProductsRequest;
use Yaspa\AdminApi\Product\Builders\GetProductsRequest;
use Yaspa\AdminApi\Product\Builders\ModifyExistingProductRequest;
use Yaspa\AdminApi\Product\Builders\ProductFields;
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
        $service = Factory::make(ProductService::class);
        $products = $service->getProducts($request);
        $this->assertTrue(is_iterable($products));
        foreach ($products as $product) {
            $this->assertInstanceOf(Product::class, $product);
            $this->assertNotEmpty($product->getId());
        }
    }

    public function testCanCountProducts()
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
        $request = Factory::make(CountProductsRequest::class)
            ->withCredentials($credentials);

        // Test method
        $service = Factory::make(ProductService::class);
        $productsCount = $service->countProducts($request);
        $this->assertEquals(3, $productsCount);
    }

    public function testCanGetProductById()
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
        $credentials = Factory::make(ApiCredentials::class)
            ->makeOAuth('foo', 'bar');

        // Test method
        $service = Factory::make(ProductService::class);
        $product = $service->getProduct($credentials, 3);
        $this->assertEquals(3, $product->getId());
        $this->assertEquals('foo', $product->getTitle());
    }

    public function testCanGetProductByIdWithParticularFields()
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
        $credentials = Factory::make(ApiCredentials::class)
            ->makeOAuth('foo', 'bar');
        $fields = Factory::make(ProductFields::class)
            ->withId()
            ->withTitle();

        // Test method
        $service = Factory::make(ProductService::class);
        $product = $service->getProduct($credentials, 3, $fields);
        $this->assertEquals(3, $product->getId());
        $this->assertEquals('foo', $product->getTitle());
    }

    public function testCanUpdateAProduct()
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
        $request = Factory::make(ModifyExistingProductRequest::class)
            ->withCredentials($credentials)
            ->withProduct($product);

        // Test method
        $service = Factory::make(ProductService::class);
        $updatedProduct = $service->modifyExistingProduct($request);
        $this->assertInstanceOf(Product::class, $updatedProduct);
    }

    public function testCanDeleteProduct()
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
        $service = Factory::make(ProductService::class);
        $result = $service->deleteProduct($credentials, 3);

        // Test results
        $this->assertTrue(is_object($result));
        $this->assertEmpty(get_object_vars($result));
    }
}
