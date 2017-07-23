<?php

require_once __DIR__.'/../bootstrap.php';

// Get test config and initialise test data
$testConfig = new Yaspa\Tests\Utils\Config();
$testApp = $testConfig->get('shopifyAppApi');
$testShop = $testConfig->get('shopifyShop');

// Get OAuth credentials for the test app
$oAuthCredentials = new Yaspa\Authentication\OAuth\Models\Credentials();
$oAuthCredentials
    ->setApiKey($testApp->key)
    ->setApiSecretKey($testApp->secretKey);

// Prepare app installation URI
$scopes = Yaspa\Factory::make(Yaspa\Authentication\OAuth\Builders\Scopes::class)
    ->withWriteCustomers()
    ->withWriteOrders();

$redirectUri = Yaspa\Factory::make(Yaspa\Authentication\OAuth\Builders\AuthorizePromptUri::class)
    ->withShop($testShop->myShopifySubdomainName)
    ->withApiKey($oAuthCredentials->getApiKey())
    ->withNonce('foo')
    ->withScopes($scopes)
    ->withRedirectUri($testApp->redirectUri)
    ->withOfflineAccess()
    ->toUri()
    ->__toString();
?>
<h1>Authorize Prompt</h1>

<a href="<?= $redirectUri ?>">Click here to authorize with Shopify</a>
