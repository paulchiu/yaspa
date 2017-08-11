<?php

namespace Yaspa\Tests\Integration\AdminApi\Product;

use GuzzleHttp\Exception\ClientException;
use Yaspa\AdminApi\Metafield\Models\Metafield;
use Yaspa\AdminApi\Product\Models\Image;
use Yaspa\AdminApi\Product\Models\Product;
use Yaspa\AdminApi\Product\Models\Variant;
use Yaspa\AdminApi\Product\ProductService;
use Yaspa\Tests\Utils\Config as TestConfig;
use Yaspa\Authentication\Factory\ApiCredentials;
use Yaspa\Factory;
use PHPUnit\Framework\TestCase;

class ProductServiceTest extends TestCase
{
    /**
     * @group integration
     */
    public function testCanCreateNewProductWithMultipleProductVariants()
    {
        // Get config
        $config = new TestConfig();
        $shop = $config->get('shopifyShop');
        $privateApp = $config->get('shopifyShopApp');

        // Create parameters
        $credentials = Factory::make(ApiCredentials::class)
            ->makePrivate(
                $shop->myShopifySubdomainName,
                $privateApp->apiKey,
                $privateApp->password
            );

        // Create request parameters
        $variant1 = (new Variant())
            ->setOption1('First')
            ->setPrice(10.00)
            ->setSku('123');
        $variant2 = (new Variant())
            ->setOption1('Second')
            ->setPrice(20.00)
            ->setSku('123');
        $product = (new Product())
            ->setTitle('Burton Custom Freestyle 151')
            ->setBodyHtml('<strong>Good snowboard!</strong>')
            ->setVendor('Burton')
            ->setProductType('Snowboard')
            ->setVariants([$variant1, $variant2]);

        // Create new product
        /** @var ProductService $service */
        $service = Factory::make(ProductService::class);
        $newProduct = $service->createNewProduct($credentials, $product);
        $this->assertInstanceOf(Product::class, $newProduct);
        $this->assertNotEmpty($newProduct->getId());
        $this->assertCount(2, $newProduct->getVariants());
        $this->assertCount(0, $newProduct->getImages());
        $this->assertFalse($newProduct->isPublished());

        return $newProduct;
    }

    /**
     * @group integration
     */
    public function testCanCreateNewProductWithDefaultVariant()
    {
        // Get config
        $config = new TestConfig();
        $shop = $config->get('shopifyShop');
        $privateApp = $config->get('shopifyShopApp');

        // Create parameters
        $credentials = Factory::make(ApiCredentials::class)
            ->makePrivate(
                $shop->myShopifySubdomainName,
                $privateApp->apiKey,
                $privateApp->password
            );

        // Create request parameters
        $image = (new Image())->setSrc('http://via.placeholder.com/300x300');
        $product = (new Product())
            ->setTitle('Burton Custom Freestyle 151')
            ->setBodyHtml('<strong>Good snowboard!</strong>')
            ->setVendor('Burton')
            ->setProductType('Snowboard')
            ->setImages([$image]);

        // Create new product
        /** @var ProductService $service */
        $service = Factory::make(ProductService::class);
        $newProduct = $service->createNewProduct($credentials, $product);
        $this->assertInstanceOf(Product::class, $newProduct);
        $this->assertNotEmpty($newProduct->getId());
        $this->assertCount(1, $newProduct->getVariants());
        $this->assertCount(1, $newProduct->getImages());
        $this->assertFalse($newProduct->isPublished());
    }

    /**
     * @group integration
     */
    public function testCanCreateNewProductWithDefaultVariantAndBase64EncodedImage()
    {
        // Get config
        $config = new TestConfig();
        $shop = $config->get('shopifyShop');
        $privateApp = $config->get('shopifyShopApp');

        // Create parameters
        $credentials = Factory::make(ApiCredentials::class)
            ->makePrivate(
                $shop->myShopifySubdomainName,
                $privateApp->apiKey,
                $privateApp->password
            );

        // Create request parameters
        $image = (new Image())
            ->setAttachment('R0lGODlhAQABAIAAAAAAAAAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==');
        $product = (new Product())
            ->setTitle('Burton Custom Freestyle 151')
            ->setBodyHtml('<strong>Good snowboard!</strong>')
            ->setVendor('Burton')
            ->setProductType('Snowboard')
            ->setImages([$image]);

        // Create new product
        /** @var ProductService $service */
        $service = Factory::make(ProductService::class);
        $newProduct = $service->createNewProduct($credentials, $product);
        $this->assertInstanceOf(Product::class, $newProduct);
        $this->assertNotEmpty($newProduct->getId());
        $this->assertCount(1, $newProduct->getVariants());
        $this->assertCount(1, $newProduct->getImages());
        $this->assertFalse($newProduct->isPublished());
    }

    /**
     * @group integration
     */
    public function testCannotCreateAProductWithoutTitle()
    {
        // Expect Guzzle client exception due to response 422
        $this->expectException(ClientException::class);

        // Get config
        $config = new TestConfig();
        $shop = $config->get('shopifyShop');
        $privateApp = $config->get('shopifyShopApp');

        // Create parameters
        $credentials = Factory::make(ApiCredentials::class)
            ->makePrivate(
                $shop->myShopifySubdomainName,
                $privateApp->apiKey,
                $privateApp->password
            );

        // Create request parameters
        $product = (new Product())->setBodyHtml('A mystery!');

        // Create new product
        /** @var ProductService $service */
        $service = Factory::make(ProductService::class);
        $service->createNewProduct($credentials, $product);
    }

    /**
     * @group integration
     */
    public function testCanCreateNewButUnpublishedProduct()
    {
        // Get config
        $config = new TestConfig();
        $shop = $config->get('shopifyShop');
        $privateApp = $config->get('shopifyShopApp');

        // Create parameters
        $credentials = Factory::make(ApiCredentials::class)
            ->makePrivate(
                $shop->myShopifySubdomainName,
                $privateApp->apiKey,
                $privateApp->password
            );

        // Create request parameters
        $product = (new Product())
            ->setTitle('Burton Custom Freestyle 151')
            ->setBodyHtml('<strong>Good snowboard!</strong>')
            ->setVendor('Burton')
            ->setProductType('Snowboard')
            ->setPublished(false);

        // Create new product
        /** @var ProductService $service */
        $service = Factory::make(ProductService::class);
        $newProduct = $service->createNewProduct($credentials, $product);
        $this->assertInstanceOf(Product::class, $newProduct);
        $this->assertFalse($newProduct->isPublished());
    }

    /**
     * @group integration
     */
    public function testCanCreateNewPublishedProduct()
    {
        // Get config
        $config = new TestConfig();
        $shop = $config->get('shopifyShop');
        $privateApp = $config->get('shopifyShopApp');

        // Create parameters
        $credentials = Factory::make(ApiCredentials::class)
            ->makePrivate(
                $shop->myShopifySubdomainName,
                $privateApp->apiKey,
                $privateApp->password
            );

        // Create request parameters
        $product = (new Product())
            ->setTitle('Burton Custom Freestyle 151')
            ->setBodyHtml('<strong>Good snowboard!</strong>')
            ->setVendor('Burton')
            ->setProductType('Snowboard')
            ->setPublished(true);

        // Create new product
        /** @var ProductService $service */
        $service = Factory::make(ProductService::class);
        $newProduct = $service->createNewProduct($credentials, $product);
        $this->assertInstanceOf(Product::class, $newProduct);
        $this->assertTrue($newProduct->isPublished());
    }

    /**
     * @group integration
     */
    public function testCanCreateProductWithMetafield()
    {
        // Get config
        $config = new TestConfig();
        $shop = $config->get('shopifyShop');
        $privateApp = $config->get('shopifyShopApp');

        // Create parameters
        $credentials = Factory::make(ApiCredentials::class)
            ->makePrivate(
                $shop->myShopifySubdomainName,
                $privateApp->apiKey,
                $privateApp->password
            );

        // Create request parameters
        $metafield = (new Metafield())
            ->setKey('new')
            ->setValue('newvalue')
            ->setValueType('string')
            ->setNamespace('global');
        $product = (new Product())
            ->setTitle('Burton Custom Freestyle 151')
            ->setBodyHtml('<strong>Good snowboard!</strong>')
            ->setVendor('Burton')
            ->setProductType('Snowboard')
            ->setMetafields([$metafield]);

        // Create new product
        /** @var ProductService $service */
        $service = Factory::make(ProductService::class);
        $newProduct = $service->createNewProduct($credentials, $product);
        $this->assertInstanceOf(Product::class, $newProduct);
        $this->assertFalse($newProduct->isPublished());
        // @todo Test metafield exists when get metafields implemented; manually checked to work for now
    }

    /**
     * @todo More tests....
     */
}
