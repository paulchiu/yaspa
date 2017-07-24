<?php

require_once __DIR__.'/../bootstrap.php';

// Get test config and initialise test data
$testConfig = new Yaspa\Tests\Utils\Config();
$testApp = $testConfig->get('shopifyAppApi');

// Get other dependencies
$authorizationCodeTransformer = Yaspa\Factory::make(Yaspa\Authentication\OAuth\Transformers\AuthorizationCode::class);
$accessTokenTransformer = Yaspa\Factory::make(Yaspa\Authentication\OAuth\Transformers\AccessToken::class);
$oAuthService = Yaspa\Factory::make(Yaspa\Authentication\OAuth\OAuthService::class);

// Get OAuth credentials for the test app
$oAuthCredentials = new Yaspa\Authentication\OAuth\Models\Credentials();
$oAuthCredentials
    ->setApiKey($testApp->key)
    ->setApiSecretKey($testApp->secretKey);

// Parse provided authorization code
$authorizationCode = $authorizationCodeTransformer->fromArray($_GET);

// Get access token
$nonce = 'foo';
$accessToken = $oAuthService->requestPermanentAccessToken($authorizationCode, $oAuthCredentials, $nonce);

// Output access key
$htmlAccessToken = var_export($accessToken, true);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Yaspa Examples - OAuth confirm installation</title>
</head>
<body>
<h1>OAuth - Confirm installation</h1>

<p>This page attempts to confirm an application installation by requesting a permanent access token from Shopify based
    on the provided query parameters.</p>

<p>Query parameters and values should be provided by Shopify and look like <code>?code=....</code>.</p>

<p>For more information please see
    <a href="https://help.shopify.com/api/getting-started/authentication/oauth#step-3-confirm-installation">Shopify's
        documentation on confirming an application installation.</a></p>

<h2>Permanent access token</h2>

<pre><?= $htmlAccessToken ?></pre>
</body>
</html>
