<?php

/**
 * @package      Oneall PHP SDK
 * @copyright    Copyright 2017-Present http://www.oneall.com
 * @license      GNU/GPL 2 or later
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307,USA.
 *
 * The "GNU General Public License" (GPL) is available at http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

namespace Oneall\Api\Apis;

use Oneall\Api\AbstractApi;
use Oneall\Api\Apis\Provider\Facebook;
use Oneall\Api\Apis\Provider\LinkedIn;
use Oneall\Api\Apis\Provider\Pinterest;
use Oneall\Api\Apis\Provider\Steam;
use Oneall\Api\Apis\Provider\Twitter;
use Oneall\Api\Apis\Provider\Youtube;
use Oneall\Client\ClientInterface;
use Oneall\Exception\ProviderApiNotFound;

/**
 * Class Provider
 *
 * @package Oneall\Api\Apis
 */
class Provider extends AbstractApi
{
    /**
     * @var AbstractApi[]
     */
    protected $providerApis = [];

    /**
     * Provider constructor.
     *
     * @param ClientInterface $client
     * @param int             $timeout
     */
    public function __construct(ClientInterface $client, $timeout = self::DEFAULT_TIMEOUT)
    {
        parent::__construct($client, $timeout);
        $this->addProviderApi(new Facebook($client, $timeout));
        $this->addProviderApi(new Steam($client, $timeout));
        $this->addProviderApi(new Youtube($client, $timeout));
        $this->addProviderApi(new LinkedIn($client, $timeout));
        $this->addProviderApi(new Twitter($client, $timeout));
        $this->addProviderApi(new Pinterest($client, $timeout));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'provider';
    }

    /**
     * List All Providers
     *
     *
     * @see http://docs.oneall.com/api/resources/providers/list-all-providers/
     *
     * @return \Oneall\Client\Response
     */
    public function getAll()
    {
        return $this->getClient()->get('/providers.json');
    }

    /**
     * Add a provider api
     *
     * @param \Oneall\Api\AbstractApi $api
     *
     * @return $this
     */
    public function addProviderApi(AbstractApi $api)
    {
        $this->providerApis[$api->getName()] = $api;

        return $this;
    }

    /**
     * Returns whether the provider api exists or not
     *
     * @param string $name
     *
     * @return bool
     */
    public function hasProviderApi($name)
    {
        if (empty($this->providerApis[$name]))
        {
            return false;
        }

        return true;
    }

    /**
     * Return the provider api
     *
     * @param string $name
     *
     * @return AbstractApi
     */
    public function getProviderApi($name)
    {
        if (!$this->hasProviderApi($name))
        {
            throw new ProviderApiNotFound($name);
        }

        return $this->providerApis[$name];
    }

    /**
     * Returns loaded provider apis name.
     *
     * @return array
     */
    public function getProvidersApiNames()
    {
        return array_keys($this->providerApis);
    }
}
