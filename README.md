OneAll PHP SDK
==============

## Getting Started

This project in a PHP SDK to use the OneAll API. It implements all API features through a curl or socket (FSockOpen) 
client. Implementation examples are available on [oneall/api-php-example](https://github.com/oneall/api-php-example) 
repository.

### Prerequisites

* webserver with PHP >=5.4
* a [oneall account](app.oneall.com) with a application created. Y'oull need your application : **subdomain**, 
**public key** and **private key**.

### Installing

> composer require "oneall/php-sdk:~1.0"

### Testing

> ./vendor/bin/phpunit tests/unit --coverage-html tests/results/unit


Documentation
-------------

You can find all documentation on [our website](http://docs.oneall.com/api/resources/). 


License
-------

The **GNU General Public License** (GPL) is available at http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
