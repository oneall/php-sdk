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

    // ****************
    // Pull API
    // ****************

    /**
     * Pull User Tweets On Twitter
     *
     * @param string $identityToken
     * @param int $num_tweets
     * @param string $after_tweet_id
     * @param string $only_tweet_id
     *
     * @see http://docs.oneall.com/api/resources/pull/twitter/tweets/
     *
     * @return \Oneall\Client\Response
     */
    public function pullTweets($identityToken, $num_tweets = 50, $after_tweet_id = '', $only_tweet_id = '')
    {
        $data = '?num_tweets=' . $num_tweets;
        $data .= !empty($after_tweet_id) ? '&after_tweet_id=' . $after_tweet_id : '';
        $data .= !empty($only_tweet_id) ? '&only_tweet_id=' . $only_tweet_id : '';

        return $this->getClient()->get('/pull/identities/' . $identityToken . '/twitter/tweets.json' . $data);
    }

    // ****************
    // Push API
    // ****************

    /**
     * Publish Tweet On Twitter
     *
     * @param string $identityToken
     * @param string $message
     * @param array  $picturesIds array of picture id on tweeter. See self::pushPicture() to upload picture and get their id.
     *
     * @see http://docs.oneall.com/api/resources/push/twitter/post/
     *
     * @return \Oneall\Client\Response
     */
    public function pushTweet($identityToken, $message, array $picturesIds = [])
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
     * Upload Picture To Twitter
     *
     * @param string $identityToken
     * @param string $url
     * @param string $description
     *
     * @see http://docs.oneall.com/api/resources/push/twitter/picture/
     *
     * @return \Oneall\Client\Response
     */
    public function pushPicture($identityToken, $url, $description = null)
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

    /**
     * Upload Video To Twitter
     *
     * @param string $identityToken
     * @param string $url
     * @param string $callback_url
     *
     * @see http://docs.oneall.com/api/resources/push/twitter/video/
     *
     * @return \Oneall\Client\Response
     */
    public function pushVideo($identityToken, $url, $callback_url = null)
    {
        $data = [
            "request" => [
                "push" => [
                    'video' => [
                        'video_url' => $url
                    ]
                ]
            ]
        ];

        // If you specify a callback_url, the result will be posted to that URL once the request has been processed.
        $this->addInfo($data, 'request/push/video/callback_url', $callback_url);

        return $this->getClient()->post('/push/identities/' . $identityToken . '/twitter/video.json', $data);
    }
}
