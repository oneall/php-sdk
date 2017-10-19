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
 * Class Analytics
 *
 * @package Oneall\Api\Apis
 */
class Analytics extends AbstractApi
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'analytics';
    }

    /**
     * List All Snapshots
     *
     * @param string $identityToken
     * @param string $userToken
     *
     * @see http://docs.oneall.com/api/resources/sharing-analytics/list-all-snapshots/
     *
     * @return \Oneall\Client\Response
     */
    public function getAll($identityToken = null, $userToken = null)
    {
        $uri   = '/sharing/analytics/snapshots.json';
        $query = [];

        if ($identityToken)
        {
            $query['identity_token'] = $identityToken;
        }

        if ($identityToken)
        {
            $query['user_token'] = $userToken;
        }

        if (!empty($query))
        {
            $uri .= '?' . http_build_query($query);
        }

        $response = $this->getClient()->get($uri);

        return $response;
    }

    /**
     * Schedule A Data Snapshot
     *
     * @param string $messageToken
     * @param string $pingbackUri
     *
     * @see http://docs.oneall.com/api/resources/sharing-analytics/initiate-snapshot/
     *
     * @return \Oneall\Client\Response
     */
    public function initiate($messageToken, $pingbackUri)
    {
        $data = [
            'request' => [
                'analytics' => [
                    'sharing' => [
                        'sharing_message_token' => $messageToken,
                        'pingback_uri' => $pingbackUri
                    ]
                ]
            ]
        ];

        return $this->getClient()->put('/sharing/analytics/snapshots.json', $data);
    }

    /**
     * Get Details Of A Snapshot
     *
     * @param string $snapshotToken
     *
     * @see http://docs.oneall.com/api/resources/sharing-analytics/read-snapshot-details/
     *
     * @return \Oneall\Client\Response
     */
    public function get($snapshotToken)
    {

        return $this->getClient()->get('/sharing/analytics/snapshots/' . $snapshotToken . '.json');
    }

    /**
     * Get Details Of A Snapshot
     *
     * @param string $snapshotToken
     *
     * @see http://docs.oneall.com/api/resources/sharing-analytics/delete-snapshot/
     *
     * @return \Oneall\Client\Response
     */
    public function delete($snapshotToken)
    {
        $uri      = '/sharing/analytics/snapshots/' . $snapshotToken . '.json?confirm_deletion=true';
        $response = $this->getClient()->delete($uri);

        return $response;
    }
}
