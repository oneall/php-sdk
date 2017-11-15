OneAll PHP SDK
==============

## Getting Started

This SDK allows you to communicate with the OneAll API using PHP. The SDK implements all API features through a curl or socket (FSockOpen) client. Implementation examples are available in the [oneall/api-php-example](https://github.com/oneall/api-php-example) 
repository.

### Prerequisites

* A webserver with PHP >=5.4
* A OneAll [account](app.oneall.com) account and site. You will need the site's **subdomain**, **public key** and **private key**.

### Installing

> composer require "oneall/php-sdk:~1.0"

### Testing

> ./vendor/bin/phpunit tests/unit --coverage-html tests/results/unit


Documentation
-------------

You can find additional information in our [documentation](http://docs.oneall.com/api/resources/). 


License
-------

**GNU General Public License**, available at http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
