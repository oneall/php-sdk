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
 * Class ShortUrl
 *
 * @package Oneall\Api\Apis
 */
class ShortUrl extends AbstractApi
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'shorturl';
    }

    /**
     * List All Shortened URLs
     *
     * @param \Oneall\Api\Pagination|null $pagination
     *
     * @see http://docs.oneall.com/api/resources/shorturls/list-all-shorturls/
     *
     * @return \Oneall\Client\Response
     */
    public function getAll(\Oneall\Api\Pagination $pagination = null)
    {
        if (!$pagination)
        {
            $pagination = new Pagination();
        }

        return $this->getClient()->get("/shorturls.json?" . $pagination->build());
    }

    /**
     * Shorten An URL
     *
     * @param string $url
     *
     * @see http://docs.oneall.com/api/resources/shorturls/create-shorturl/
     *
     * @return \Oneall\Client\Response
     */
    public function create($url)
    {
        $data = [
            'request' => [
                'shorturl' => [
                    'original_url' => $url
                ]
            ]
        ];

        return $this->getClient()->post('/shorturls.json', $data);
    }

    /**
     * Read Details Of A Shortened URL
     *
     * @param string $shorturl_token
     *
     * @see http://docs.oneall.com/api/resources/shorturls/read-shorturl-details/
     *
     * @return \Oneall\Client\Response
     */
    public function get($shorturl_token)
    {
        return $this->getClient()->get('/shorturls/' . $shorturl_token . '.json');
    }

    /**
     * Delete A Shortened URL
     *
     * @param string $shorturl_token
     *
     * @see http://docs.oneall.com/api/resources/shorturls/delete-shorturl/
     *
     * @return \Oneall\Client\Response
     */
    public function delete($shorturl_token)
    {
        return $this->getClient()->delete('/shorturls/' . $shorturl_token . '.json?confirm_deletion=true');
    }
}
