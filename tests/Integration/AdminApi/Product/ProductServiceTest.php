<?php

namespace Yaspa\Tests\Integration\AdminApi\Product;

use GuzzleHttp\Exception\ClientException;
use Yaspa\AdminApi\Metafield\Models\Metafield;
use Yaspa\AdminApi\Product\Builders\CountProductsRequest;
use Yaspa\AdminApi\Product\Builders\GetProductsRequest;
use Yaspa\AdminApi\Product\Builders\ModifyExistingProductRequest;
use Yaspa\AdminApi\Product\Builders\ProductFields;
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
        $service = Factory::make(ProductService::class);
        $newProduct = $service->createNewProduct($credentials, $product);
        $this->assertInstanceOf(Product::class, $newProduct);
        $this->assertNotEmpty($newProduct->getId());
        $this->assertCount(2, $newProduct->getVariants());
        $this->assertCount(0, $newProduct->getImages());
        $this->assertFalse($newProduct->isPublished());
        $this->assertEmpty($newProduct->getTags());

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
        $service = Factory::make(ProductService::class);
        $newProduct = $service->createNewProduct($credentials, $product);
        $this->assertInstanceOf(Product::class, $newProduct);
        $this->assertNotEmpty($newProduct->getId());
        $this->assertCount(1, $newProduct->getVariants());
        $this->assertCount(1, $newProduct->getImages());
        $this->assertFalse($newProduct->isPublished());
        $this->assertEmpty($newProduct->getTags());

        return $newProduct;
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
        $service = Factory::make(ProductService::class);
        $newProduct = $service->createNewProduct($credentials, $product);
        $this->assertInstanceOf(Product::class, $newProduct);
        $this->assertNotEmpty($newProduct->getId());
        $this->assertCount(1, $newProduct->getVariants());
        $this->assertCount(1, $newProduct->getImages());
        $this->assertFalse($newProduct->isPublished());
        $this->assertEmpty($newProduct->getTags());
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
        $service = Factory::make(ProductService::class);
        $service->createNewProduct($credentials, $product);
    }

    /**
     * @group integration
     * @return Product
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
        $service = Factory::make(ProductService::class);
        $newProduct = $service->createNewProduct($credentials, $product);
        $this->assertInstanceOf(Product::class, $newProduct);
        $this->assertFalse($newProduct->isPublished());
        $this->assertEmpty($newProduct->getTags());

        return $newProduct;
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
        $service = Factory::make(ProductService::class);
        $newProduct = $service->createNewProduct($credentials, $product);
        $this->assertInstanceOf(Product::class, $newProduct);
        $this->assertTrue($newProduct->isPublished());

        return $newProduct;
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
        $service = Factory::make(ProductService::class);
        $newProduct = $service->createNewProduct($credentials, $product);
        $this->assertInstanceOf(Product::class, $newProduct);
        $this->assertFalse($newProduct->isPublished());
        $this->assertEmpty($newProduct->getTags());

        return $newProduct;
    }

    /**
     * @depends testCanCreateProductWithMetafield
     * @group integration
     * @param Product $product
     * @return array
     */
    public function testCanCreateNewProductMetafield(Product $product)
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
        $metafield = (new Metafield())
            ->setNamespace('inventory')
            ->setKey('warehouse')
            ->setValue(25)
            ->setValueType('integer');

        // Test method
        $service = Factory::make(ProductService::class);
        $metafield = $service->createNewProductMetafield($credentials, $product, $metafield);
        $this->assertNotEmpty($metafield->getId());
        $this->assertNotEmpty($metafield->getKey());
        $this->assertNotEmpty($metafield->getValue());
        $this->assertInstanceOf(Metafield::class, $metafield);
        return [$product, $metafield];
    }

    /**
     * @depends testCanCreateNewProductMetafield
     * @group integration
     * @param array $newProductMetafield
     * @return Product
     */
    public function testCanUpdateProductMetafield(array $newProductMetafield)
    {
        // Destructure dependent parameters
        /** @var Product $product */
        /** @var Metafield $metafield */
        [$product, $metafield] = $newProductMetafield;
        $this->assertEquals(25, $metafield->getValue());

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

        // Update metafield
        $metafield->setValue(27);

        // Test method
        $service = Factory::make(ProductService::class);
        $updatedMetafield = $service->updateProductMetafield($credentials, $product, $metafield);
        $this->assertInstanceOf(Metafield::class, $updatedMetafield);
        $this->assertEquals($metafield->getId(), $updatedMetafield->getId());
        $this->assertEquals($metafield->getKey(), $updatedMetafield->getKey());
        $this->assertEquals($metafield->getValue(), $updatedMetafield->getValue());
        return $product;
    }

    /**
     * @depends testCanUpdateProductMetafield
     * @group integration
     * @param Product $product
     */
    public function testCanGetProductMetafields(Product $product)
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

        // Set expectations
        $expectedMetafieldValues = [
            'new' => 'newvalue',
            'warehouse' => 27,
        ];

        // Test method
        $service = Factory::make(ProductService::class);
        $metafields = $service->getProductMetafields($credentials, $product->getId());
        foreach ($metafields as $metafield) {
            $this->assertNotEmpty($metafield->getId());
            $this->assertNotEmpty($metafield->getKey());
            $this->assertNotEmpty($metafield->getValue());
            $this->assertInstanceOf(Metafield::class, $metafield);
            $expectedValue = $expectedMetafieldValues[$metafield->getKey()];
            $this->assertEquals($expectedValue, $metafield->getValue());
        }
    }

    /**
     * @depends testCanCreateNewProductMetafield
     * @group integration
     * @param array $newProductMetafield
     */
    public function testCanDeleteProductMetafield(array $newProductMetafield)
    {
        // Destructure dependent parameters
        /** @var Product $product */
        /** @var Metafield $metafield */
        [$product, $metafield] = $newProductMetafield;

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

        // Update metafield
        $metafield->setValue(27);

        // Test method
        $service = Factory::make(ProductService::class);
        $result = $service->deleteProductMetafield($credentials, $product, $metafield);
        $this->assertTrue(is_object($result));
        $this->assertEmpty(get_object_vars($result));
    }

    /**
     * @group integration
     */
    public function testCanCreateNewProductWithDefaultProductVariant()
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
            ->setTags(['Barnes & Noble', 'John\'s Fav', 'Big Air']);

        // Create new product
        $service = Factory::make(ProductService::class);
        $newProduct = $service->createNewProduct($credentials, $product);
        $this->assertInstanceOf(Product::class, $newProduct);
        $this->assertNotEmpty($newProduct->getTags());
        $this->assertCount(1, $newProduct->getVariants());
    }

    /**
     * @depends testCanCreateNewProductWithMultipleProductVariants
     * @group integration
     */
    public function testCanGetAllProductsShowingOnlySomeAttributes()
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

        // Create request
        $fields = Factory::make(ProductFields::class)
            ->withId()
            ->withImages()
            ->withTitle();
        $request = Factory::make(GetProductsRequest::class)
            ->withCredentials($credentials)
            ->withProductFields($fields)
            ->withLimit(1);

        // Get and test results
        $service = Factory::make(ProductService::class);
        $products = $service->getProducts($request);
        $this->assertTrue(is_iterable($products));
        foreach ($products as $product) {
            $this->assertInstanceOf(Product::class, $product);
            $this->assertNotEmpty($product->getId());
            break;
        }
    }

    /**
     * @depends testCanCreateNewProductWithMultipleProductVariants
     * @group integration
     */
    public function testCanGetAllProducts()
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

        // Create request
        $request = Factory::make(GetProductsRequest::class)
            ->withCredentials($credentials)
            ->withLimit(1);

        // Get and test results
        $service = Factory::make(ProductService::class);
        $products = $service->getProducts($request);
        $this->assertTrue(is_iterable($products));
        foreach ($products as $product) {
            $this->assertInstanceOf(Product::class, $product);
            $this->assertNotEmpty($product->getId());
            break;
        }
    }

    /**
     * @depends testCanCreateNewProductWithMultipleProductVariants
     * @group integration
     * @param Product $newProduct
     */
    public function testCanGetAListOfSpecificProducts(Product $newProduct)
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

        // Create request
        $request = Factory::make(GetProductsRequest::class)
            ->withCredentials($credentials)
            ->withIds([$newProduct->getId()]);

        // Get and test results
        $service = Factory::make(ProductService::class);
        $products = $service->getProducts($request);
        $this->assertTrue(is_iterable($products));
        foreach ($products as $product) {
            $this->assertInstanceOf(Product::class, $product);
            $this->assertEquals($newProduct->getId(), $product->getId());
        }
    }

    /**
     * @depends testCanCreateNewProductWithMultipleProductVariants
     * @group integration
     */
    public function testCanCountAllProducts()
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

        // Create request
        $request = Factory::make(CountProductsRequest::class)
            ->withCredentials($credentials);

        // Get and test results
        $service = Factory::make(ProductService::class);
        $productsCount = $service->countProducts($request);
        $this->assertGreaterThan(0, $productsCount);
    }

    /**
     * @depends testCanCreateNewProductWithMultipleProductVariants
     * @group integration
     * @param Product $product
     */
    public function testCanGetProductById(Product $product)
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

        // Get and test results
        $service = Factory::make(ProductService::class);
        $retrievedProduct = $service->getProduct($credentials, $product->getId());
        $this->assertEquals($product->getId(), $retrievedProduct->getId());
        $this->assertNotEmpty($retrievedProduct->getVendor());
    }

    /**
     * @depends testCanCreateNewProductWithMultipleProductVariants
     * @group integration
     * @param Product $product
     */
    public function testCanGetProductByIdWithParticularFields(Product $product)
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
        $fields = Factory::make(ProductFields::class)
            ->withId()
            ->withTitle();

        // Get and test results
        $service = Factory::make(ProductService::class);
        $retrievedProduct = $service->getProduct($credentials, $product->getId(), $fields);
        $this->assertEquals($product->getId(), $retrievedProduct->getId());
        $this->assertEmpty($retrievedProduct->getVendor());
    }

    /**
     * @depends testCanCreateNewProductWithMultipleProductVariants
     * @group integration
     * @param Product $originalProduct
     */
    public function testCanUpdateAProductAndOneOfItsVariants(Product $originalProduct)
    {
        // Get config
        $config = new TestConfig();
        $shop = $config->get('shopifyShop');
        $privateApp = $config->get('shopifyShopApp');

        // Check pre-conditions
        $this->assertCount(2, $originalProduct->getVariants());
        [$originalVariant1, $originalVariant2] = $originalProduct->getVariants();

        // Create parameters
        $credentials = Factory::make(ApiCredentials::class)
            ->makePrivate(
                $shop->myShopifySubdomainName,
                $privateApp->apiKey,
                $privateApp->password
            );
        $toBeUpdatedVariant1 = (new Variant())
            ->setId($originalVariant1->getId())
            ->setPrice(2000.00)
            ->setSku('Updating the Product SKU');
        $toBeUpdatedVariant2 = (new Variant())
            ->setId($originalVariant2->getId());
        $toBeUpdatedProduct = (new Product())
            ->setId($originalProduct->getId())
            ->setTitle('Updated Product Title')
            ->setVariants([$toBeUpdatedVariant1, $toBeUpdatedVariant2]);
        $request = Factory::make(ModifyExistingProductRequest::class)
            ->withCredentials($credentials)
            ->withProduct($toBeUpdatedProduct);

        // Get and test results
        $service = Factory::make(ProductService::class);
        $updatedProduct = $service->modifyExistingProduct($request);
        $this->assertEquals($toBeUpdatedProduct->getId(), $updatedProduct->getId());
        $this->assertEquals($toBeUpdatedProduct->getTitle(), $updatedProduct->getTitle());
        $this->assertNotEmpty($updatedProduct->getVendor());
        [$updatedVariant1, $updatedVariant2] = $updatedProduct->getVariants();
        $this->assertEquals($toBeUpdatedVariant1->getId(), $updatedVariant1->getId());
        $this->assertEquals($toBeUpdatedVariant1->getSku(), $updatedVariant1->getSku());
        $this->assertEquals(1, $updatedVariant1->getPosition());
        $this->assertEquals(2, $updatedVariant2->getPosition());
    }

    /**
     * @depends testCanCreateNewProductWithMultipleProductVariants
     * @group integration
     * @param Product $originalProduct
     */
    public function testCanUpdateAProductReorderingTheProductVariants(Product $originalProduct)
    {
        // Get config
        $config = new TestConfig();
        $shop = $config->get('shopifyShop');
        $privateApp = $config->get('shopifyShopApp');

        // Check pre-conditions
        $this->assertCount(2, $originalProduct->getVariants());
        [$originalVariant1, $originalVariant2] = $originalProduct->getVariants();

        // Create parameters
        $credentials = Factory::make(ApiCredentials::class)
            ->makePrivate(
                $shop->myShopifySubdomainName,
                $privateApp->apiKey,
                $privateApp->password
            );
        $toBeUpdatedVariant1 = (new Variant())->setId($originalVariant1->getId());
        $toBeUpdatedVariant2 = (new Variant())->setId($originalVariant2->getId());
        $toBeUpdatedProduct = (new Product())
            ->setId($originalProduct->getId())
            ->setVariants([$toBeUpdatedVariant2, $toBeUpdatedVariant1]);
        $request = Factory::make(ModifyExistingProductRequest::class)
            ->withCredentials($credentials)
            ->withProduct($toBeUpdatedProduct);

        // Get and test results
        $service = Factory::make(ProductService::class);
        $updatedProduct = $service->modifyExistingProduct($request);
        $this->assertEquals($toBeUpdatedProduct->getId(), $updatedProduct->getId());
        [$updatedVariant1, $updatedVariant2] = $updatedProduct->getVariants();
        $this->assertEquals($toBeUpdatedVariant1->getId(), $updatedVariant2->getId());
        $this->assertEquals($toBeUpdatedVariant2->getId(), $updatedVariant1->getId());
    }

    /**
     * @depends testCanCreateNewProductWithMultipleProductVariants
     * @group integration
     * @param Product $originalProduct
     */
    public function testCanUpdateAProductsTags(Product $originalProduct)
    {
        // Get config
        $config = new TestConfig();
        $shop = $config->get('shopifyShop');
        $privateApp = $config->get('shopifyShopApp');

        // Check pre-conditions
        $this->assertEmpty($originalProduct->getTags());

        // Create parameters
        $credentials = Factory::make(ApiCredentials::class)
            ->makePrivate(
                $shop->myShopifySubdomainName,
                $privateApp->apiKey,
                $privateApp->password
            );
        $toBeUpdatedProduct = (new Product())
            ->setId($originalProduct->getId())
            ->setTags(['Barnes & Noble', "John's Fav"]);
        $request = Factory::make(ModifyExistingProductRequest::class)
            ->withCredentials($credentials)
            ->withProduct($toBeUpdatedProduct);

        // Get and test results
        $service = Factory::make(ProductService::class);
        $updatedProduct = $service->modifyExistingProduct($request);
        $this->assertCount(2, $updatedProduct->getTags());
    }

    /**
     * @depends testCanCreateNewProductWithDefaultVariant
     * @group integration
     * @param Product $originalProduct
     * @return Product
     */
    public function testCanUpdateAProductAddingANewProductImage($originalProduct)
    {
        // Get config
        $config = new TestConfig();
        $shop = $config->get('shopifyShop');
        $privateApp = $config->get('shopifyShopApp');

        // Check pre-conditions
        $this->assertCount(1, $originalProduct->getImages());
        [$originalImage] = $originalProduct->getImages();

        // Create parameters
        $credentials = Factory::make(ApiCredentials::class)
            ->makePrivate(
                $shop->myShopifySubdomainName,
                $privateApp->apiKey,
                $privateApp->password
            );
        $toBeUpdatedOriginalImage = (new Image())->setId($originalImage->getId());
        $additionalImage = (new Image())->setSrc('http://via.placeholder.com/303x303');
        $toBeUpdatedProduct = (new Product())
            ->setId($originalProduct->getId())
            ->setImages([$toBeUpdatedOriginalImage, $additionalImage]);
        $request = Factory::make(ModifyExistingProductRequest::class)
            ->withCredentials($credentials)
            ->withProduct($toBeUpdatedProduct);

        // Get and test results
        $service = Factory::make(ProductService::class);
        $updatedProduct = $service->modifyExistingProduct($request);
        $this->assertCount(2, $updatedProduct->getImages());
        [$updatedImage1, $updatedImage2] = $updatedProduct->getImages();
        $this->assertEquals($originalImage->getId(), $updatedImage1->getId());

        return $updatedProduct;
    }

    /**
     * @depends testCanCreateNewPublishedProduct
     * @group integration
     * @param Product $originalProduct
     */
    public function testCanHideAPublishedProduct(Product $originalProduct)
    {
        // Get config
        $config = new TestConfig();
        $shop = $config->get('shopifyShop');
        $privateApp = $config->get('shopifyShopApp');

        // Check pre-conditions
        $this->assertTrue($originalProduct->isPublished());

        // Create parameters
        $credentials = Factory::make(ApiCredentials::class)
            ->makePrivate(
                $shop->myShopifySubdomainName,
                $privateApp->apiKey,
                $privateApp->password
            );
        $toBeUpdatedProduct = (new Product())
            ->setId($originalProduct->getId())
            ->setPublished(false);
        $request = Factory::make(ModifyExistingProductRequest::class)
            ->withCredentials($credentials)
            ->withProduct($toBeUpdatedProduct);

        // Get and test results
        $service = Factory::make(ProductService::class);
        $updatedProduct = $service->modifyExistingProduct($request);
        $this->assertFalse($updatedProduct->isPublished());
    }

    /**
     * @depends testCanCreateNewProductWithDefaultVariant
     * @group integration
     * @param Product $originalProduct
     */
    public function testCanUpdateAProductsSEOTitleAndDescription(Product $originalProduct)
    {
        // Get config
        $config = new TestConfig();
        $shop = $config->get('shopifyShop');
        $privateApp = $config->get('shopifyShopApp');

        // Check pre-conditions
        $this->assertEmpty($originalProduct->getMetafieldsGlobalTitleTag());
        $this->assertEmpty($originalProduct->getMetafieldsGlobalDescriptionTag());

        // Create parameters
        $credentials = Factory::make(ApiCredentials::class)
            ->makePrivate(
                $shop->myShopifySubdomainName,
                $privateApp->apiKey,
                $privateApp->password
            );
        $toBeUpdatedProduct = (new Product())
            ->setId($originalProduct->getId())
            ->setMetafieldsGlobalTitleTag('Brand new title')
            ->setMetafieldsGlobalDescriptionTag('Brand new description');
        $request = Factory::make(ModifyExistingProductRequest::class)
            ->withCredentials($credentials)
            ->withProduct($toBeUpdatedProduct);

        // Get and test results
        $service = Factory::make(ProductService::class);
        $updatedProduct = $service->modifyExistingProduct($request);
        /**
         * @todo Figure out how to verify meta titles as it is not returned as part of a product resource
         */
    }

    /**
     * @depends testCanCreateNewProductWithDefaultVariant
     * @group integration
     * @param Product $originalProduct
     */
    public function testCanUpdateAProductClearingProductImages(Product $originalProduct)
    {
        // Get config
        $config = new TestConfig();
        $shop = $config->get('shopifyShop');
        $privateApp = $config->get('shopifyShopApp');

        // Check pre-conditions
        $this->assertCount(1, $originalProduct->getImages());

        // Create parameters
        $credentials = Factory::make(ApiCredentials::class)
            ->makePrivate(
                $shop->myShopifySubdomainName,
                $privateApp->apiKey,
                $privateApp->password
            );
        $toBeUpdatedProduct = (new Product())
            ->setId($originalProduct->getId())
            ->setImages([]);
        $request = Factory::make(ModifyExistingProductRequest::class)
            ->withCredentials($credentials)
            ->withProduct($toBeUpdatedProduct);

        // Get and test results
        $service = Factory::make(ProductService::class);
        $updatedProduct = $service->modifyExistingProduct($request);
        $this->assertEmpty($updatedProduct->getImages());
    }

    /**
     * @depends testCanCreateNewProductWithMultipleProductVariants
     * @group integration
     */
    public function testCanUpdateAProductReorderingProductImage()
    {
        // Get config
        $config = new TestConfig();
        $shop = $config->get('shopifyShop');
        $privateApp = $config->get('shopifyShopApp');
        $credentials = Factory::make(ApiCredentials::class)
            ->makePrivate(
                $shop->myShopifySubdomainName,
                $privateApp->apiKey,
                $privateApp->password
            );
        $service = Factory::make(ProductService::class);

        // Check pre-conditions
        $originalImage1 = (new Image())->setSrc('http://via.placeholder.com/301x301');
        $originalImage2 = (new Image())->setSrc('http://via.placeholder.com/302x302');
        $originalProduct = (new Product())
            ->setTitle('Burton Custom Freestyle 151')
            ->setBodyHtml('<strong>Good snowboard!</strong>')
            ->setImages([$originalImage1, $originalImage2]);
        $originalProduct = $service->createNewProduct($credentials, $originalProduct);
        $this->assertCount(2, $originalProduct->getImages());
        [$image1, $image2] = $originalProduct->getImages();

        // Create parameters
        $toBeUpdatedImage1 = (new Image())
            ->setId($image1->getId())
            ->setPosition(2);
        $toBeUpdatedImage2 = (new Image())
            ->setId($image2->getId())
            ->setPosition(1);
        $toBeUpdatedProduct = (new Product())
            ->setId($originalProduct->getId())
            ->setImages([$toBeUpdatedImage1, $toBeUpdatedImage2]);
        $request = Factory::make(ModifyExistingProductRequest::class)
            ->withCredentials($credentials)
            ->withProduct($toBeUpdatedProduct);

        // Get and test results
        $updatedProduct = $service->modifyExistingProduct($request);
        $this->assertCount(2, $updatedProduct->getImages());
        [$updatedImage1, $updatedImage2] = $updatedProduct->getImages();
        $this->assertEquals($image2->getId(), $updatedImage1->getId());
        $this->assertEquals($image1->getId(), $updatedImage2->getId());
    }

    /**
     * @depends testCanCreateNewButUnpublishedProduct
     * @group integration
     * @param Product $originalProduct
     */
    public function testCanShowAHiddenProduct(Product $originalProduct)
    {
        // Get config
        $config = new TestConfig();
        $shop = $config->get('shopifyShop');
        $privateApp = $config->get('shopifyShopApp');

        // Check pre-conditions
        $this->assertFalse($originalProduct->isPublished());

        // Create parameters
        $credentials = Factory::make(ApiCredentials::class)
            ->makePrivate(
                $shop->myShopifySubdomainName,
                $privateApp->apiKey,
                $privateApp->password
            );
        $toBeUpdatedProduct = (new Product())
            ->setId($originalProduct->getId())
            ->setPublished(true);
        $request = Factory::make(ModifyExistingProductRequest::class)
            ->withCredentials($credentials)
            ->withProduct($toBeUpdatedProduct);

        // Get and test results
        $service = Factory::make(ProductService::class);
        $updatedProduct = $service->modifyExistingProduct($request);
        $this->assertTrue($updatedProduct->isPublished());
    }

    /**
     * @depends testCanCreateNewProductWithMultipleProductVariants
     * @group integration
     * @param Product $product
     */
    public function testCanAddAMetafieldToAnExistingProduct(Product $product)
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
        $service = Factory::make(ProductService::class);

        // Get pre-update-state
        $preUpdateMetafields = $service->getProductMetafields($credentials, $product->getId());

        // Create update parameters
        $metafield = (new Metafield())
            ->setKey('new')
            ->setValue('newvalue')
            ->setValueType('string')
            ->setNamespace('global');
        $toBeUpdatedProduct = (new Product)
            ->setId($product->getId())
            ->setMetafields([$metafield]);
        $request = Factory::make(ModifyExistingProductRequest::class)
            ->withCredentials($credentials)
            ->withProduct($toBeUpdatedProduct);

        // Test update
        $updatedProduct = $service->modifyExistingProduct($request);
        $postUpdateMetafields = $service->getProductMetafields($credentials, $updatedProduct->getId());
        $this->assertEquals(count($preUpdateMetafields) + 1, count($postUpdateMetafields));
    }

    /**
     * @depends testCanCreateNewProductWithMultipleProductVariants
     * @group integration
     * @param Product $originalProduct
     */
    public function testCanDeleteProduct(Product $originalProduct)
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

        // Test pre-state
        $this->assertNotEmpty($originalProduct->getId());

        // Test service method
        $service = Factory::make(ProductService::class);
        $result = $service->deleteProduct($credentials, $originalProduct->getId());
        $this->assertTrue(is_object($result));
        $this->assertEmpty(get_object_vars($result));
    }

    /**
     * @todo Test fetch all products that belong to a certain collection once collection service is implemented
     * @todo Test count all products that belong to a certain collection
     * @todo Test get all metafields that belong to the images of a product
     */
}
