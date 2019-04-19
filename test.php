<?php

// Autoloader for Composer
require_once 'vendor/autoload.php';

// create the client through our builder
$builder = new Oneall\Client\Builder();

$sitePublicKey = '#PUBLIC_KEY#';
$sitePrivateKey = '#PRIVATE_KEY#';
$subDomain = '#SUBDOMAIN#';

$client = $builder->build('curl', $subDomain, $sitePublicKey, $sitePrivateKey, true, 'oneall.com');
$api = new \Oneall\OneallApi($client);

// pagination
$pagination = new Oneall\Api\Pagination(1, 10);

// ****************
// Connection API
// ****************

// List all connections
$connectionApi = $api->getConnectionApi();
$connectionApiResponse = $connectionApi->getAll($pagination);
print_r('<pre>');
print_r("================================== \n");
print_r("====== List all connections ====== \n\n");
print_r($connectionApiResponse->getBody());
print_r("\n\n================================== \n");
print_r("================================== \n\n\n\n\n\n");
print_r('</pre>');

// ****************
// Identity API
// ****************

// SHow all
$identityApi = $api->getIdentityApi();
$identityApiResponse = $identityApi->getAll($pagination);
print_r('<pre>');
print_r("================================== \n");
print_r("====== List all identities ====== \n\n");
print_r($identityApiResponse->getBody());
print_r("\n\n================================== \n");
print_r("================================== \n\n\n\n\n\n");
print_r('</pre>');

// ****************
// Providers API
// ****************

// List all provider
$providerApi = $api->getProviderApi();
$providerApiResponse = $providerApi->getAll($pagination);
print_r('<pre>');
print_r("================================== \n");
print_r("====== List all provider ====== \n\n");
print_r($providerApiResponse->getBody());
print_r("\n\n================================== \n");
print_r("================================== \n\n\n\n\n\n");
print_r('</pre>');

// ****************
// Twitter
// ****************

$provider = 'twitter';

// Twitter API
$twitterApi = $api->getProviderApi()->getProviderApi($provider);
$identity_token = "#IDENTITY_TOKEN#";

// Push a tweet
$twitterApiResponse = $twitterApi->pushTweet($identity_token, 'Hello');
print_r('<pre>');
print_r("================================== \n");
print_r("====== Push a tweet ====== \n\n");
print_r($twitterApiResponse->getBody());
print_r("\n\n================================== \n");
print_r("================================== \n\n\n\n\n\n");
print_r('</pre>');

// Get all tweets
$twitterApiResponse = $twitterApi->pullTweets($identity_token);
print_r('<pre>');
print_r("================================== \n");
print_r("====== Pull tweets ====== \n\n");
print_r($twitterApiResponse->getBody());
print_r("\n\n================================== \n");
print_r("================================== \n\n\n\n\n\n");
print_r('</pre>');
