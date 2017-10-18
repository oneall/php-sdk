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

namespace Oneall\Api\Apis\Provider;

use Oneall\Api\AbstractApi;
use Oneall\Exception\BadMethodCallException;

/**
 * Class Facebook
 *
 * This provider is used for all interaction with facebook social network
 *
 * @package Oneall\Api\Apis\Provider
 */
class Facebook extends AbstractApi
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'facebook';
    }

    /**
     * Facebook \ List Posts
     *
     * @param string $identityToken
     * @param array  $options
     *
     * @see http://docs.oneall.com/api/resources/identities/facebook/list-posts/
     *
     * @return \Oneall\Client\Response
     */
    public function getPosts($identityToken, array $options = [])
    {
        return $this->getClient()->get('/identities/' . $identityToken . '/facebook/posts.json', $options);
    }

    /**
     * Facebook \ List Posts
     *
     * @param array $options
     *
     * @see http://docs.oneall.com/api/resources/providers/facebook/list-all-pages/
     *
     * @return \Oneall\Client\Response
     */
    public function getPages(array $options = [])
    {
        return $this->getClient()->get('/providers/facebook/pages.json', $options);
    }

    /**
     * Facebook \ List Posts
     *
     * @param array $options
     *
     * @see http://docs.oneall.com/api/resources/providers/facebook/list-all-pages/
     *
     * @return \Oneall\Client\Response
     */
    /**
     * @param string $pageToken
     * @param string $text
     * @param array  $link an array with the following elements :url, name, caption, description
     * @param string $pictureUrl
     * @param array  $options
     *
     * @return \Oneall\Client\Response
     */
    public function publish($pageToken, $text, array $link = [], $pictureUrl = null, array $options = [])
    {
        if (empty($text) && empty($link['url']))
        {
            throw new BadMethodCallException('Either a text or a link url must be supplied.');
        }

        $data = [
            'request' => [
                'page_message' => [
                    'parts' => [
                        'text' => [],
                        'picture' => [],
                        'link' => [],
                    ]
                ]
            ]
        ];

        $data = $this->addInfo($data, 'request/page_message/parts/text/body', $text);
        $data = $this->addInfo($data, 'request/page_message/parts/picture/url', $pictureUrl);
        $data = $this->addInfo($data, 'request/page_message/parts/link', $link);

        return $this->getClient()->post('/providers/facebook/pages/' . $pageToken . '/publish.json', $data, $options);
    }
}
