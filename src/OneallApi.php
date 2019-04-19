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

namespace Oneall;

use Oneall\Api\Apis\Connection;
use Oneall\Api\Apis\Identity;
use Oneall\Api\Apis\Provider;
use Oneall\Api\Apis\Sharing;
use Oneall\Api\Apis\SharingAnalytics;
use Oneall\Api\Apis\ShortUrl;
use Oneall\Api\Apis\Site;
use Oneall\Api\Apis\Sso;
use Oneall\Api\Apis\Storage;
use Oneall\Api\Apis\User;
use Oneall\Api\Registry;
use Oneall\Client\ClientInterface;
use Oneall\Client\ProxyConfiguration;

class OneallApi
{
    const API_CONNECTION = 'connection';
    const API_IDENTITY = 'identity';
    const API_PROVIDER = 'provider';
    const API_SHARING = 'sharing';
    const API_SHORTURL = 'shorturl';
    const API_SSO = 'sso';
    const API_STORAGE = 'storage';
    const API_USER = 'user';
    const API_SITE = 'site';
    const API_SHARING_ANALYTICS = 'sharing_analytics';

    /**
     * @var ClientInterface
     */
    protected $client;

    /**
     * @var ProxyConfiguration
     */
    protected $proxy;

    /**
     * @var Registry
     */
    protected $registry;

    /**
     * Token storage eto communicate between api.
     *
     * All kind of token are stored : identities, user, connection, ...
     *
     * @var array
     */
    protected $token = [];

    /**
     * OneallApi constructor.
     *
     * @param \Oneall\Client\ClientInterface         $client
     * @param \Oneall\Client\ProxyConfiguration|null $proxy
     * @param \Oneall\Api\Registry|null              $registry
     */
    public function __construct(ClientInterface $client, ProxyConfiguration $proxy = null, Registry $registry = null)
    {
        $this->client = $client;
        $this->proxy = $proxy;

        // configure a full a default complete registry
        if (!$registry)
        {
            $registry = new Registry();
            $registry->add(new Connection($client))
                ->add(new Identity($client))
                ->add(new Provider($client))
                ->add(new Sharing($client))
                ->add(new SharingAnalytics($client))
                ->add(new ShortUrl($client))
                ->add(new Sso($client))
                ->add(new Storage($client))
                ->add(new User($client))
                ->add(new Site($client))
            ;
        }
        $this->registry = $registry;
    }

    /**
     * @return \Oneall\Client\ClientInterface
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param \Oneall\Client\ClientInterface $client
     *
     * @return $this
     */
    public function setClient(ClientInterface $client)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * @return \Oneall\Client\ProxyConfiguration
     */
    public function getProxy()
    {
        return $this->proxy;
    }

    /**
     * @param \Oneall\Client\ProxyConfiguration $proxy
     *
     * @return $this
     */
    public function setProxy(ProxyConfiguration $proxy)
    {
        $this->proxy = $proxy;

        return $this;
    }

    /**
     * @return \Oneall\Api\Registry
     */
    public function getRegistry()
    {
        return $this->registry;
    }

    /**
     * @param Registry $registry
     *
     * @return $this
     */
    public function setRegistry(Registry $registry)
    {
        $this->registry = $registry;

        return $this;
    }

    /**
     * @return Connection
     */
    public function getConnectionApi()
    {
        return $this->getRegistry()->get(self::API_CONNECTION);
    }

    /**
     * @return Identity
     */
    public function getIdentityApi()
    {
        return $this->getRegistry()->get(self::API_IDENTITY);
    }

    /**
     * @return Provider
     */
    public function getProviderApi()
    {
        return $this->getRegistry()->get(self::API_PROVIDER);
    }

    /**
     * @return Sharing
     */
    public function getSharingApi()
    {
        return $this->getRegistry()->get(self::API_SHARING);
    }

    /**
     * @return ShortUrl
     */
    public function getShorturlApi()
    {
        return $this->getRegistry()->get(self::API_SHORTURL);
    }

    /**
     * @return Sso
     */
    public function getSsoApi()
    {
        return $this->getRegistry()->get(self::API_SSO);
    }

    /**
     * @return Storage
     */
    public function getStorageApi()
    {
        return $this->getRegistry()->get(self::API_STORAGE);
    }

    /**
     * @return User
     */
    public function getUserApi()
    {
        return $this->getRegistry()->get(self::API_USER);
    }

    /**
     * @return Site
     */
    public function getSiteApi()
    {
        return $this->getRegistry()->get(self::API_SITE);
    }

    /**
     * @return Site
     */
    public function getSharingAnalyticsApi()
    {
        return $this->getRegistry()->get(self::API_SHARING_ANALYTICS);
    }
}
