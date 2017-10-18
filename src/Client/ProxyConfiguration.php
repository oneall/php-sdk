<?php

/**
 * @package      Oneall Single Sign-On
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

namespace Oneall\Client;

/**
 * Class ProxyConfiguration
 *
 * @package Oneall\Client
 */
class ProxyConfiguration
{
    /**
     * @var string
     */
    protected $proxyUrl;
    /**
     * @var int
     */
    protected $proxyPort;
    /**
     * @var string
     */
    protected $proxyUsername;
    /**
     * @var string
     */
    protected $proxyPassword;

    /**
     * @return string
     */
    public function getProxyUrl()
    {
        return $this->proxyUrl;
    }

    /**
     * @param string $proxyUrl
     *
     * @return $this
     */
    public function setProxyUrl($proxyUrl)
    {
        $this->proxyUrl = $proxyUrl;

        return $this;
    }

    /**
     * @return int
     */
    public function getProxyPort()
    {
        return $this->proxyPort;
    }

    /**
     * @param int $proxyPort
     *
     * @return $this
     */
    public function setProxyPort($proxyPort)
    {
        $this->proxyPort = $proxyPort;

        return $this;
    }

    /**
     * @return string
     */
    public function getProxyUsername()
    {
        return $this->proxyUsername;
    }

    /**
     * @param string $proxyUsername
     *
     * @return $this
     */
    public function setProxyUsername($proxyUsername)
    {
        $this->proxyUsername = $proxyUsername;

        return $this;
    }

    /**
     * @return string
     */
    public function getProxyPassword()
    {
        return $this->proxyPassword;
    }

    /**
     * @param string $proxyPassword
     *
     * @return $this
     */
    public function setProxyPassword($proxyPassword)
    {
        $this->proxyPassword = $proxyPassword;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return get_object_vars($this);
    }
}
