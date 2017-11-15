OneAll PHP SDK
==============

The SDK allows you to communicate with the OneAll API using PHP. It implements all API features through a curl or socket (FSockOpen) client. Implementation examples are available in the [oneall/php-api-examples](https://github.com/oneall/php-api-examples) repository.

## Getting Started


### Prerequisites

* A webserver with PHP >=5.4
* A free OneAll [account](app.oneall.com) and a site. You will need the site's **subdomain**, **public key** and **private key**.

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
