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

namespace Oneall\Api\Apis\Provider;

use Oneall\Api\AbstractApi;

/**
 * Class Pinterest
 *
 * This provider is used for all interaction with Pinterest provider.
 *
 * @package Oneall\Api\Apis\Provider
 */
class Pinterest extends AbstractApi
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'pinterest';
    }

    /**
     * Pinterest \ List boards
     *
     * @param string $identityToken
     *
     * @see https://docs.oneall.com/api/resources/pull/pinterest/boards/
     *
     * @return \Oneall\Client\Response
     */
    public function getBoards($identityToken)
    {
        return $this->getClient()->get('/pull/identities/' . $identityToken . '/pinterest/boards.json');
    }

    /**
     * Pinterest \ List boards
     *
     * @param string $identityToken
     * @param string $board
     * @param string $note
     * @param string $image_url
     * @param null   $link
     *
     * @see https://docs.oneall.com/api/resources/push/pinterest/pin/
     *
     * @return \Oneall\Client\Response
     */
    public function publishPin($identityToken, $board, $note, $image_url, $link = null)
    {
        $data = [
            'request' => [
                'push' => [
                    'pin' => [
                        "board" => $board,
                        "note" => $note,
                        "image_url" => $image_url,
                    ]
                ]
            ]
        ];

        $data = $this->addInfo($data, 'request/push/pin/link', $link);

        return $this->getClient()->post('/push/identities/' . $identityToken . '/pinterest/pin.json', $data);
    }
}
