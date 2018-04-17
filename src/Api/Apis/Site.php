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

/**
 * Class Site
 *
 * @package Oneall\Api\Apis
 */
class Site extends AbstractApi
{
    const CONNECTION_LOG_SIGNIN = 'signin';
    const CONNECTION_LOG_SIGNUP = 'signup';

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'site';
    }

    /**
     * List all allowed domains
     *
     * @see https://docs.oneall.com/api/resources/site/allowed-domains/
     *
     * @return \Oneall\Client\Response
     */
    public function getAllowedDomains()
    {
        return $this->getClient()->get('/site/allowed-domains.json');
    }

    /**
     * Add allowed domains
     *
     * @param array $domains
     *
     * @see http://docs.oneall.com/api/resources/sites/read-site-details/
     *
     * @return \Oneall\Client\Response
     */
    public function addAllowedDomains(array $domains)
    {
        $data = [
            'request' => [
                'allowed_domains' => $domains
            ]
        ];

        return $this->getClient()->put('/site/allowed-domains.json', $data);
    }

    /**
     * Return connection log list
     *
     * @return \Oneall\Client\Response
     */
    public function getConnectionLogs()
    {
        return $this->getClient()->get('/site/connections.json');
    }

    /**
     * Store a new connection log for a classic "form" login.
     *
     * @param string $type signin or signup
     * @param string $username
     * @param string $email
     *
     * @return \Oneall\Client\Response
     */
    public function createConnectionLog($type, $username, $email)
    {
        $data = [
            'request' => [
                'connection' => [
                    "type" => $type,
                    "username" => $username,
                    "email" => $email
                ],
            ],
        ];

        return $this->getClient()->post('/site/connections.json', $data);
    }
}
