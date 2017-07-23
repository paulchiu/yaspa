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

// Set the scopes we want
$scopes = Yaspa\Factory::make(Yaspa\Authentication\OAuth\Builders\Scopes::class)
    ->withWriteCustomers()
    ->withWriteOrders();

// Prepare app installation URI
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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Yaspa Examples - OAuth authorization prompt</title>
</head>
<body>
<h1>OAuth - Authorize Prompt</h1>

<p>This authorization prompt, aka application installation prompt, is intended for use by public Shopify
    applications. That is, applications that utilise OAuth tokens for authentication with the Shopify API.</p>

<p>Please note that for private application, it is much easier to utilise a private authentication key to interact
    with the Shopify API.</p>

<p>For more information please see
    <a href="https://help.shopify.com/api/getting-started/authentication/oauth#step-2-ask-for-permission">Shopify's
        documentation on asking the user for OAuth permissions.</a></p>

<h2>Before you start</h2>

<h3>Using the example publicly (online hosted) </h3>

<ul>
    <li>Make the contents of the <code>examples</code> folder accessible online.</li>
    <li>Ensure <code>test-config.json</code> has been created and filled in. See <code>test-config.example.json</code>
        for field value expectations.</li>
    <li>Ensure your Shopify application's whitelisted redirect URLs include where <code>confirm-installation.php</code>
        is hosted</li>
</ul>

<h3>Using the example privately (local/dev hosted)</h3>

<p>If you do not wish to publish the example folder online:</p>

<ul>
    <li>Make the contents of the <code>examples</code> folder accessible locally, such as at <code>http://localhost/</code></li>
    <li>Use <code>http://httpbin.org/anything</code> as the whitelisted redirect URL.</li>
    <li>Once you authorize your application, Shopify will redirect the browser to <code>http://httpbin.org/</code></li>
    <li>Copy and paste the query parameters of <code>?code=....</code> and append it to a URL similar to
        <code>http://localhost/oauth/confirm-installation</code></li>
</ul>

<h2>Application install link</h2>
<a href="<?= $redirectUri ?>">Click here to authorize with Shopify</a>
</body>
</html>
