OneAll PHP SDK
==============

The SDK allows you to communicate with the OneAll API using PHP. It implements all API features through a curl or socket (FSockOpen) client. Implementation examples are available in the [oneall/php-api-examples](https://github.com/oneall/php-api-examples) repository.

## Getting Started


### Prerequisites

* A webserver with PHP >=5.4
* A free OneAll [account](app.oneall.com) and a site. You will need the site's **subdomain**, **public key** and **private key**.

### Installing

> composer require "oneall/php-sdk:~2.0"

### Testing

> ./vendor/bin/phpunit tests/unit --coverage-html tests/results/unit


Using our PHP-SDK
-----------------

The PHP-SDK is composed of
* PHP clients (curl & FSockOpen) & a builder
* Apis object to use our differents endpoints.
* An ApiContainer containing all Apis object.

### Get you configuration

In order to use the PHP-SDK, you'll need your application credentials you can find on [our website](app.oneall.com).

    $subDomain = 'your-subdomain';
    $sitePublicKey = 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx';
    $sitePrivateKey = 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx';

### Create the client

First, you'll have to create a php client which contains the previous credentials. You can choose between *curl or 
*fsockopen*, depending on your system.
damie
    // create the client through our builder
    $builder = new Oneall\Client\Builder();
    $client = $builder->build('curl', $subDomain, $sitePublicKey, $sitePrivateKey);
    
    // Or build it directly
    $curlClient = new \Oneall\Client\Adapter\Curl($subDomain, $sitePublicKey, $sitePrivateKey);

### Use our API objects

Finally, instantiate the ApiObject you need (checkout our [api documentation](http://docs.oneall.com/api/resources/)
for more details). Each ApiObject needs the client in order to interact (and automatically log in) with ours services.

    $connectionApi = new \Oneall\Api\Apis\Connection($client);
    $connections = $api->getConnectionApi()->getAll();

You may use our ApiContainer to ease their instantiation.

    $api = new \Oneall\OneallApi($client);
    $connections = $api->getConnectionApi()->getAll();

For example, if you want to publish a message on Twitter.

    $api = new \Oneall\OneallApi($client);
    $twitter_api = $api->getProviderApi()->getProviderApi('twitter');
    $twitter_api->publish($identity_token, $message);
    

Documentation
-------------

More inforation on our [documentation](http://docs.oneall.com/api/resources/). 

Here is a [step-by-step documetation](http://docs.oneall.com/services/implementation-guide/) for implementing our 
Social Login, Social Link and Single Sign-On services on a website that already has users with accounts.


License
-------

**GNU General Public License**, available at http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
