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

    // ****************
    // Pull API
    // ****************

    /**
     * Facebook \ List Posts
     *
     * @param string $identityToken
     * @param int $num_posts
     * @param int $page
     * @param boolean $limit_own_posts
     *
     * @see http://docs.oneall.com/api/resources/pull/facebook/posts/
     *
     * @return \Oneall\Client\Response
     */
    public function pullPosts($identityToken, $num_posts = 50, $page = 1, $limit_own_posts = false)
    {
        $data = '?num_posts=' . $num_posts;
        $data .= !empty($page) && is_int($page) ? '&page=' . $page : '';
        $data .= is_bool($limit_own_posts) ? '&limit_own_posts=' . (int) $limit_own_posts : '';

        return $this->getClient()->get('/pull/identities/' . $identityToken . '/facebook/posts.json' . $data);
    }

    /**
     * Facebook \ List Page Posts
     *
     * @param string $identityToken
     * @param int $num_posts
     * @param int $page
     * @param boolean $limit_own_posts
     *
     * @see http://docs.oneall.com/api/resources/pull/facebook/posts/
     *
     * @return \Oneall\Client\Response
     */
    public function pullPagePosts($identityToken, $pageId, $num_posts = 50, $page = 1)
    {
        $data = '?num_posts=' . $num_posts;
        $data .= !empty($page) && is_int($page) ? '&page=' . $page : '';

        return $this->getClient()->get('/pull/identities/' . $identityToken . '/facebook/page/' . $pageId . '/posts.json' . $data);
    }

    /**
     * Facebook \ List Pages
     *
     * @see http://docs.oneall.com/api/resources/pull/facebook/pages/
     *
     * @param string $identityToken
     * @param int $num_pages
     * @param int $page
     *
     * @return \Oneall\Client\Response
     */
    public function pullPages($identityToken, $num_pages = 25, $page = 1)
    {
        $data = '?num_pages=' . $num_pages;
        $data .= !empty($page) && is_int($page) ? '&page=' . $page : '';

        return $this->getClient()->get('/pull/identities/' . $identityToken . '/facebook/pages.json' . $data);
    }

    /**
     * Facebook \ List Likes
     *
     * @see http://docs.oneall.com/api/resources/pull/facebook/likes/
     *
     * @param string $identityToken
     * @param int $num_likes
     * @param int $page
     *
     * @return \Oneall\Client\Response
     */
    public function pullLikes($identityToken, $num_likes = 25, $page = 1)
    {
        $data = '?num_likes=' . $num_likes;
        $data .= !empty($page) && is_int($page) ? '&page=' . $page : '';

        return $this->getClient()->get('/pull/identities/' . $identityToken . '/facebook/likes.json' . $data);
    }

    /**
     * Upload Picture To facebook
     *
     * @param string $identityToken
     * @param string $url
     * @param string $description
     *
     * @see http://docs.oneall.com/api/resources/push/facebook/picture/
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

        return $this->getClient()->post('/push/identities/' . $identityToken . '/facebook/picture.json', $data);
    }

    // ****************
    // Push API
    // ****************

    /**
     * Publish page post
     *
     * @param string $identityToken
     * @param string $url
     * @param string $description
     *
     * @see http://docs.oneall.com/api/resources/push/facebook/page/post/
     *
     * @return \Oneall\Client\Response
     */
    public function pushPagePosts($identityToken, $pageId, $message, $link = '', array $picturesIds = [])
    {
        $data = [
            "request" => [
                "push" => [
                    'page' => [
                        'id' => $pageId,
                        'message' => $message,
                        'attachments' => $picturesIds
                    ]
                ]
            ]
        ];

        // adding link if set
        $data = $this->addInfo($data, 'request/push/page/link', $link);

        return $this->getClient()->post('/push/identities/' . $identityToken . '/facebook/page/post.json', $data);
    }

    /**
     * Publish page picture
     *
     * @param string $identityToken
     * @param string $pageId
     * @param string $url
     * @param string $description
     *
     * @see http://docs.oneall.com/api/resources/push/facebook/page/picture/
     *
     * @return \Oneall\Client\Response
     */
    public function pushPagePicture($identityToken, $pageId, $url, $description = null)
    {
        $data = [
            "request" => [
                "push" => [
                    'page' => [
                        'id' => $pageId,
                        'url' => $url
                    ]
                ]
            ]
        ];

        // adding description if set
        $data = $this->addInfo($data, 'request/push/page/description', $description);

        return $this->getClient()->post('/push/identities/' . $identityToken . '/facebook/page/picture.json', $data);
    }
}
