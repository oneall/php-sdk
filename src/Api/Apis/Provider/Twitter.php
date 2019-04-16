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

class Twitter extends AbstractApi
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'twitter';
    }

    /**
     * List tweets by user
     *
     * @see http://docs.oneall.com/api/resources/social-network/twitter/search/
     *
     * @param null|string $user_id
     * @param null|string $screen_name
     * @param int         $count
     *
     * @return \Oneall\Client\Response|string
     */
    public function searchByUser($user_id = null, $screen_name = null, $count = 100)
    {
        $parameters = [
            'count' => $count,
            'screen_name' => $screen_name,
            'user_id' => $user_id
        ];

        $query_parameters = http_build_query(array_filter($parameters));
        $uri = '/site/providers/twitter/tweets/search-by-user.json';
        if ($query_parameters)
        {
            $uri .= '?' . $query_parameters;
        }

        return $this->getClient()->get($uri);
    }

    /**
     * List tweets
     *
     * @see http://docs.oneall.com/api/resources/social-network/twitter/search/
     *
     * @param string $query
     * @param int    $count
     *
     * @return \Oneall\Client\Response|string
     */
    public function search($query, $count = 100)
    {
        $query_parameters = http_build_query(array_filter(['query' => $query, 'count' => $count]));
        $uri = '/site/providers/twitter/tweets/search.json';
        if ($query_parameters)
        {
            $uri .= '?' . $query_parameters;
        }

        return $this->getClient()->get($uri);
    }

    /**
     * Publish Tweet On Twitter
     *
     * @param string $identityToken
     * @param string $message
     * @param array  $picturesIds array of picture id on tweeter. See self::upload() to upload picture and get their id.
     *
     * @see http://docs.oneall.com/api/resources/push/twitter/post/
     *
     * @return \Oneall\Client\Response
     */
    public function publish($identityToken, $message, array $picturesIds = [])
    {
        $data = [
            "request" => [
                "push" => [
                    'post' => [
                        'message' => $message,
                        'attachments' => $picturesIds
                    ]
                ]
            ]
        ];

        return $this->getClient()->post('/push/identities/' . $identityToken . '/twitter/post.json', $data);
    }

    /**
     * Publish Tweet On Twitter
     *
     * @param string $identityToken
     * @param string $message
     * @param array  $picturesIds array of picture id on tweeter. See self::upload() to upload picture and get their id.
     *
     * @see http://docs.oneall.com/api/resources/push/twitter/post/
     *
     * @return \Oneall\Client\Response
     */
    public function getTweets($identityToken, $num_tweets = 0)
    {
        $data = !empty($num_tweets) ? '?num_tweets=' . $num_tweets : '';

        return $this->getClient()->get('/pull/identities/' . $identityToken . '/twitter/tweets.json' . $data);
    }

    /**
     * Upload Picture To Twitter
     *
     * @param      $identityToken
     * @param      $url
     * @param null $description
     *
     * @see http://docs.oneall.com/api/resources/push/twitter/picture/
     *
     * @return \Oneall\Client\Response
     */
    public function upload($identityToken, $url, $description = null)
    {
        $data = [
            "request" => [
                "push" => [
                    'picture' => [
                        'url' => $url
                    ]
                ]
            ]
        ];

        // adding picture description if set
        $this->addInfo($data, 'request/push/picture/description', $description);

        return $this->getClient()->post('/push/identities/' . $identityToken . '/twitter/picture.json', $data);
    }
}
