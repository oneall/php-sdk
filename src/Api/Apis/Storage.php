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
 * Class Storage
 *
 * @package Oneall\Api\Apis
 */
class Storage extends AbstractApi
{

    const MODE_UPDATE_REPLACE = 'replace';
    const MODE_UPDATE_APPEND  = 'append';

    /**
     * @return string
     */
    public function getName()
    {
        return 'storage';
    }

    /**
     * Add user to storage
     *
     * @param string $externalId
     * @param string $login
     * @param string $password
     * @param array  $identity
     *
     * @see http://docs.oneall.com/api/resources/storage/users/create-user/
     *
     * @return \Oneall\Client\Response
     */
    public function createUser(
        array $identity,
        $externalId = null,
        $login = null,
        $password = null
    ) {
        $data = [
            "request" => [
                "user" => [
                    "identity" => $identity
                ]
            ]
        ];

        $data = $this->addInfo($data, 'request/user/externalid', $externalId);
        $data = $this->addInfo($data, 'request/user/login', $login);
        $data = $this->addInfo($data, 'request/user/password', $password);

        return $this->getClient()->post('/storage/users.json', $data);
    }

    /**
     * Update user data
     *
     * @param string $userToken
     * @param mixed  $externalId
     * @param string $login
     * @param string $password
     * @param array  $identity
     * @param string $mode
     *
     * @see http://docs.oneall.com/api/resources/storage/users/update-user/
     *
     * @return null|\Oneall\Client\Response null if nothing to update
     */
    public function updateUser(
        $userToken,
        $externalId = null,
        $login = null,
        $password = null,
        array $identity = [],
        $mode = self::MODE_UPDATE_REPLACE
    ) {

        if (empty($externalId) && empty($login) && empty($password) && empty($identity))
        {
            return null;
        }

        $data = [
            "request" => [
                'update_mode' => $mode,
                "user" => []
            ]
        ];

        $data = $this->addInfo($data, 'request/user/externalid', $externalId);
        $data = $this->addInfo($data, 'request/user/login', $login);
        $data = $this->addInfo($data, 'request/user/password', $password);
        $data = $this->addInfo($data, 'request/user/identity', $identity);

        return $this->getClient()->put('/storage/users/' . $userToken . '.json', $data);
    }

    /**
     * Map an external user id to a user token
     *
     * @param $userToken
     * @param $externalId
     *
     * @see http://docs.oneall.com/api/resources/storage/users/update-user/
     *
     * @return \Oneall\Client\Response
     */
    public function mapUserAccount($userToken, $externalId)
    {
        $data = [
            "request" => [
                "user" => [
                    "externalid" => $externalId,
                ]
            ]
        ];

        return $this->getClient()->post('/storage/users/' . $userToken . '.json', $data);
    }

    /**
     * Look up user by its external id.
     *
     * @param mixed $externalId
     *
     * @see http://docs.oneall.com/api/resources/storage/users/lookup-user/
     *
     * @return \Oneall\Client\Response
     */
    public function lookUpById($externalId)
    {
        $data = [
            "request" => [
                "user" => [
                    "externalid" => $externalId,
                ]
            ]
        ];

        return $this->getClient()->post('/storage/users/user/lookup.json', $data);
    }

    /**
     * Look up user by its credentials
     *
     * @param string      $login
     * @param string|null $password
     *
     * @see http://docs.oneall.com/api/resources/storage/users/lookup-user/
     *
     * @return \Oneall\Client\Response
     */
    public function lookUpByCredentials($login, $password = null)
    {
        $data = [
            "request" => [
                "user" => [
                    "login" => $login
                ]
            ]
        ];

        $data = $this->addInfo($data, 'request/user/password', $password);

        return $this->getClient()->post('/storage/users/user/lookup.json', $data);
    }
}
