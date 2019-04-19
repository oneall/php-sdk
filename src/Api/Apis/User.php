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
use Oneall\Api\Pagination;

/**
 * Class User
 *
 * @package Oneall\Api\Apis
 */
class User extends AbstractApi
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'user';
    }

    /**
     * List all users
     *
     * @see http://docs.oneall.com/api/resources/users/list-all-users/
     *
     * @return \Oneall\Client\Response
     */
    public function getAll(Pagination $pagination = null)
    {
        if (!$pagination)
        {
            $pagination = new Pagination();
        }

        return $this->getClient()->get('/users.json?' . $pagination->build());
    }

    /**
     * Retrieve user details
     *
     * @param string $user_token
     *
     * @see http://docs.oneall.com/api/resources/users/read-user-details/
     *
     * @return \Oneall\Client\Response
     */
    public function get($user_token)
    {
        return $this->getClient()->get('/users/' . $user_token . '.json');
    }

    /**
     * Create a user from access token
     *
     * @param string $providerKey
     * @param string $accessTokenKey
     * @param string $userToken
     * @param string $accessTokenSecret
     *
     * @see http://docs.oneall.com/api/resources/users/import-user/
     *
     * @return \Oneall\Client\Response
     */
    public function createUser(
        $providerKey,
        $accessTokenKey,
        $userToken = null,
        $accessTokenSecret = null
    )
    {
        $data = [
            "request" => [
                "user" => [
                    "identity" => [
                        "source" => [
                            "key" => $providerKey,
                            "access_token" => [
                                "key" => $accessTokenKey
                            ]
                        ]
                    ]
                ]
            ]
        ];

        $data = $this->addInfo($data, 'request/user/identity/source/access_token/secret', $accessTokenSecret);
        $data = $this->addInfo($data, 'request/user/user_token/', $userToken);

        return $this->getClient()->put('/users.json', $data);
    }

    /**
     * Delete a user
     *
     * @param string $user_token
     *
     * @see http://docs.oneall.com/api/resources/users/delete-user/
     *
     * @return \Oneall\Client\Response
     */
    public function delete($user_token)
    {
        return $this->getClient()->delete('/users/' . $user_token . '.json?confirm_deletion=true');
    }

    /**
     * Read User's Contacts
     *
     * @param string $user_token
     * @param bool   $disableCache
     *
     * @see http://docs.oneall.com/api/resources/users/read-contacts/
     *
     * @return \Oneall\Client\Response
     */
    public function getContacts($user_token, $disableCache = false)
    {
        $uri = '/users/' . $user_token . '/contacts.json';
        if ($disableCache)
        {
            $uri .= '?disable_cache=true';
        }

        return $this->getClient()->get($uri);
    }
}
