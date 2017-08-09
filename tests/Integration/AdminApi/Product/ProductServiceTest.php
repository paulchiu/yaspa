<?php

namespace Yaspa\Tests\Integration\AdminApi\Product;

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

        return $newProduct;
    }

    /**
     * @todo More create new product tests
     */
}
