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

namespace Oneall\Api\Apis;

use Oneall\Api\AbstractApi;

/**
 * Class Identity
 *
 * @package Oneall\Api\Apis
 */
class Identity extends AbstractApi
{
    /**
     * {@inheritdoc
     */
    public function getName()
    {
        return 'identity';
    }

    /**
     * List all identities
     *
     *
     * @see http://docs.oneall.com/api/resources/identities/list-all-identities/
     *
     * @return \Oneall\Client\Response
     */
    public function getAll()
    {
        return $this->getClient()->get('/identities.json');
    }

    /**
     * Read Identity Details
     *
     * @param string $identityToken
     *
     * @see http://docs.oneall.com/api/resources/identities/list-all-identities/
     *
     * @return \Oneall\Client\Response
     */
    public function get($identityToken)
    {
        return $this->getClient()->get('/identities/' . $identityToken . '.json');
    }

    /**
     * Delete Identity
     *
     * @param string $identityToken
     *
     * @see http://docs.oneall.com/api/resources/identities/delete-identity/
     *
     * @return \Oneall\Client\Response
     */
    public function delete($identityToken)
    {
        return $this->getClient()->delete('/identities/' . $identityToken . '.json?confirm_deletion=true');
    }

    /**
     * ReLink Identity
     *
     * @param string $identityToken
     *
     * @see http://docs.oneall.com/api/resources/identities/relink-identity/
     *
     * @return \Oneall\Client\Response
     */
    public function relink($identityToken, $userToken)
    {
        $data = [
            'request' => [
                'user' => [
                    'user_token' => $userToken
                ]
            ]
        ];

        return $this->getClient()->put('/identities/' . $identityToken . '/link.json', $data);
    }

    /**
     * Synchronize Identity
     *
     * @param string $identityToken
     * @param bool   $updateUserData
     * @param bool   $forceTokenUpdate
     *
     * @see http://docs.oneall.com/api/resources/identities/synchronize-identity/
     *
     * @return \Oneall\Client\Response
     */
    public function synchronize($identityToken, $updateUserData = true, $forceTokenUpdate = false)
    {
        $data = [
            'request' => [
                'synchronize' => [
                    'update_user_data' => (bool) $updateUserData,
                    'force_token_update' => (bool) $forceTokenUpdate,
                ]
            ]
        ];

        return $this->getClient()->put('/identities/' . $identityToken . '/synchronize.json', $data);
    }

    /**
     * Read Identity Contacts
     *
     * @param string $identityToken
     *
     * @see http://docs.oneall.com/api/resources/identities/read-contacts/
     *
     * @return \Oneall\Client\Response
     */
    public function getContacts($identityToken)
    {
        return $this->getClient()->get('/identities/' . $identityToken . '/contacts.json');
    }
}
