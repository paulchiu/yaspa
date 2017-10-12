<?php

namespace Yaspa\Tests\Integration\AdminApi\Redirect;

use GuzzleHttp\Exception\ClientException;
use PHPUnit\Framework\TestCase;
use Yaspa\AdminApi\Redirect\Builders\CountAllRedirectsRequest;
use Yaspa\AdminApi\Redirect\Builders\GetRedirectsRequest;
use Yaspa\AdminApi\Redirect\Builders\ModifyExistingRedirectRequest;
use Yaspa\AdminApi\Redirect\Builders\RedirectFields;
use Yaspa\AdminApi\Redirect\Models\Redirect;
use Yaspa\AdminApi\Redirect\RedirectService;
use Yaspa\Authentication\Factory\ApiCredentials;
use Yaspa\Factory;
use Yaspa\Tests\Utils\Config as TestConfig;

class RedirectServiceTest extends TestCase
{
    /**
     * @group integration
     * @return Redirect
     */
    public function testCanCreateNewRedirect()
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
        $redirect = (new Redirect())
            ->setPath(uniqid('/ipod-'))
            ->setTarget('/pages/itunes');

        // Create new script tag
        $service = Factory::make(RedirectService::class);
        $newRedirect = $service->createNewRedirect($credentials, $redirect);
        $this->assertInstanceOf(Redirect::class, $newRedirect);
        $this->assertNotEmpty($newRedirect->getId());
        $this->assertNotEmpty($newRedirect->getPath());
        $this->assertNotEmpty($newRedirect->getTarget());

        return $newRedirect;
    }

    /**
     * @group integration
     * @return Redirect
     */
    public function testCanCreateNewRedirectWithFullUrls()
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
        $redirect = (new Redirect())
            ->setPath(uniqid('http://www.apple.com/forums/'))
            ->setTarget('http://forums.apple.com');

        // Create new script tag
        $service = Factory::make(RedirectService::class);
        $newRedirect = $service->createNewRedirect($credentials, $redirect);
        $this->assertInstanceOf(Redirect::class, $newRedirect);
        $this->assertNotEmpty($newRedirect->getId());
        $this->assertNotEmpty($newRedirect->getPath());
        $this->assertNotEmpty($newRedirect->getTarget());

        return $newRedirect;
    }

    /**
     * @group integration
     */
    public function testCannotCreateARedirectWithoutAPathAndTarget()
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
        $redirect = new Redirect();

        // Create new Script Tag
        $service = Factory::make(RedirectService::class);
        $service->createNewRedirect($credentials, $redirect);
    }

    /**
     * @depends testCanCreateNewRedirect
     * @group integration
     */
    public function testCanGetAllRedirectsShowingOnlySomeAttributes()
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
        $fields = Factory::make(RedirectFields::class)
            ->withId()
            ->withPath();
        $request = Factory::make(GetRedirectsRequest::class)
            ->withCredentials($credentials)
            ->withRedirectFields($fields)
            ->withLimit(1);

        // Get and test results
        $service = Factory::make(RedirectService::class);
        $redirects = $service->getRedirects($request);
        $this->assertTrue(is_iterable($redirects));
        foreach ($redirects as $redirect) {
            $this->assertInstanceOf(Redirect::class, $redirect);
            $this->assertNotEmpty($redirect->getId());
            $this->assertNotEmpty($redirect->getPath());
            $this->assertEmpty($redirect->getTarget());
            break;
        }
    }

    /**
     * @group integration
     */
    public function testCanGetRedirects()
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
        $request = Factory::make(GetRedirectsRequest::class)
            ->withCredentials($credentials)
            ->withLimit(1);

        // Get and test results
        $service = Factory::make(RedirectService::class);
        $redirects = $service->getRedirects($request);

        // Confirm we can move through pages seamlessly
        $targetIterations = 2;
        $timesIterated = 0;
        foreach ($redirects as $index => $redirect) {
            if ($timesIterated >= $targetIterations) {
                break;
            }

            $this->assertInstanceOf(Redirect::class, $redirect);
            $timesIterated++;
        }
        $this->assertGreaterThanOrEqual($targetIterations, $timesIterated);
    }

    /**
     * @depends testCanCreateNewRedirect
     * @group integration
     */
    public function testCanCountAllRedirects()
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
        $request = Factory::make(CountAllRedirectsRequest::class)
            ->withCredentials($credentials);

        // Test service method
        $service = Factory::make(RedirectService::class);
        $result = $service->countRedirects($request);
        $this->assertGreaterThan(0, $result);
    }

    /**
     * @depends testCanCreateNewRedirect
     * @group integration
     */
    public function testCanCountAllRedirectsWithTarget()
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
        $request = Factory::make(CountAllRedirectsRequest::class)
            ->withCredentials($credentials)
            ->withTarget('http://forums.apple.com');

        // Test service method
        $service = Factory::make(RedirectService::class);
        $result = $service->countRedirects($request);
        $this->assertGreaterThan(0, $result);
    }

    /**
     * @depends testCanCreateNewRedirect
     * @group integration
     * @param Redirect $originalRedirect
     */
    public function testCanUpdateARedirectPath(Redirect $originalRedirect)
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
        $redirectUpdate = (new Redirect())
            ->setId($originalRedirect->getId())
            ->setPath('/tiger');
        $request = Factory::make(ModifyExistingRedirectRequest::class)
            ->withCredentials($credentials)
            ->withRedirect($redirectUpdate);

        // Get and Test results
        $service = Factory::make(RedirectService::class);
        $updatedRedirect = $service->modifyExistingRedirect($request);
        $this->assertEquals($originalRedirect->getId(), $updatedRedirect->getId());
        $this->assertEquals($originalRedirect->getTarget(), $updatedRedirect->getTarget());
        $this->assertNotEquals($originalRedirect->getPath(), $updatedRedirect->getPath());
    }

    /**
     * @depends testCanCreateNewRedirect
     * @group integration
     * @param Redirect $originalRedirect
     */
    public function testCanUpdateBothTargetAndRedirectUris(Redirect $originalRedirect)
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
        $redirectUpdate = (new Redirect())
            ->setId($originalRedirect->getId())
            ->setPath('/powermac')
            ->setTarget('/pages/macpro');
        $request = Factory::make(ModifyExistingRedirectRequest::class)
            ->withCredentials($credentials)
            ->withRedirect($redirectUpdate);

        // Get and Test results
        $service = Factory::make(RedirectService::class);
        $updatedRedirect = $service->modifyExistingRedirect($request);
        $this->assertEquals($originalRedirect->getId(), $updatedRedirect->getId());
        $this->assertNotEquals($originalRedirect->getPath(), $updatedRedirect->getPath());
        $this->assertNotEquals($originalRedirect->getTarget(), $updatedRedirect->getTarget());
    }

    /**
     * @depends testCanCreateNewRedirect
     * @group integration
     * @param Redirect $redirect
     */
    public function testCanGetRedirectById(Redirect $redirect)
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
        $service = Factory::make(RedirectService::class);
        $retrievedRedirect = $service->getRedirectById($credentials, $redirect->getId());
        $this->assertEquals($redirect->getId(), $retrievedRedirect->getId());
        $this->assertNotEmpty($retrievedRedirect->getPath());
        $this->assertNotEmpty($retrievedRedirect->getTarget());
    }

    /**
     * @depends testCanCreateNewRedirect
     * @group integration
     * @param Redirect $redirect
     */
    public function testCanDeleteRedirectById(Redirect $redirect)
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
        $this->assertNotEmpty($redirect->getId());

        // Test service method
        $service = Factory::make(RedirectService::class);
        $result = $service->deleteRedirectById($credentials, $redirect->getId());
        $this->assertTrue(is_object($result));
        $this->assertEmpty(get_object_vars($result));
    }
}

