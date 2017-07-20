<?php

require_once __DIR__.'/../../bootstrap.php';

// Get test config and initialise test data
$testConfig = new Yaspa\Tests\Utils\Config();
$testApp = $testConfig->get('shopifyAppApi');

// Get other dependencies
$confirmationRedirectTransformer = Yaspa\Factory::make(Yaspa\Transformers\Authentication\OAuth\ConfirmationRedirect::class);
$confirmInstallation = Yaspa\Factory::make(Yaspa\OAuth\ConfirmInstallation::class);

// Get OAuth credentials for the test app
$oAuthCredentials = new Yaspa\Models\Authentication\OAuth\Credentials();
$oAuthCredentials
    ->setApiKey($testApp->key)
    ->setApiSecretKey($testApp->secretKey);

// Parse provided confirmation
$confirmation = $confirmationRedirectTransformer->fromArray($_GET);

// Get access token
$nonce = 'foo';
$response = $confirmInstallation->requestPermanentAccessToken($confirmation, $oAuthCredentials, $nonce);

// Output access key
echo '<pre>';
var_dump(json_decode($response->getBody()->getContents()));
