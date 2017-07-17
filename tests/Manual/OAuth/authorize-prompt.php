<?php

require_once __DIR__.'/../../bootstrap.php';

$pathToTestCredentials = __DIR__.'/../../../test-credentials.json';
$testCredentials = json_decode(file_get_contents($pathToTestCredentials));

$oAuthCredentials = new Yaspa\Models\Authentication\OAuth\Credentials();
$oAuthCredentials
    ->setApiKey($testCredentials->shopifyAppApi->key)
    ->setApiSecretKey($testCredentials->shopifyAppApi->secretKey);

$redirectUri = (new Yaspa\OAuth\AuthorizePrompt($testCredentials->shopifyAppApi->redirectUri))
    ->withShop($testCredentials->shopifyShop->myShopifySubdomainName)
    ->withApiKey($oAuthCredentials->getApiKey())
    ->withReadCustomersScope()
    ->withWriteCustomersScope()
    ->withOfflineAccess()
    ->toUri()
    ->__toString();
?>
<h1>Authorize Prompt</h1>

<a href="<?= $redirectUri ?>">Click here to authorize with Shopify</a>
