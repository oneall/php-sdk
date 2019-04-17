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
    public function listPages()
    {
        return $this->getClient()->get('/providers/facebook/pages.json');
    }

    /**
     * Publish on a page
     *
     *
     * @see http://docs.oneall.com/api/resources/providers/facebook/write-to-page/
     *
     * @return \Oneall\Client\Response
     */
    /**
     * @param string $pageToken
     * @param string $text
     * @param array  $link an array with the following elements :url, name, caption, description
     * @param string $pictureUrl
     *
     * @return \Oneall\Client\Response
     */
    public function publish($pageToken, $text, array $link = [], $pictureUrl = null)
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
                        'link' => []
                    ]
                ]
            ]
        ];

        $data = $this->addInfo($data, 'request/page_message/parts/text/body', $text);
        $data = $this->addInfo($data, 'request/page_message/parts/picture/url', $pictureUrl);
        $data = $this->addInfo($data, 'request/page_message/parts/link', $link);

        return $this->getClient()->post('/providers/facebook/pages/' . $pageToken . '/publish.json', $data);
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

    // ****************
    // Push API
    // ****************

    /**
     * Publish page post
     *
     * @param string $identityToken
     * @param string $message
     * @param array  $picturesIds array of picture id. See self::pushPicture() to upload picture and get their id.
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

    // /**
    //  * Upload a picture.
    //  *
    //  * @param string       $identityToken
    //  * @param string       $url
    //  * @param null |string $description
    //  * @param bool         $createPost
    //  *
    //  * @return \Oneall\Client\Response
    //  */
    // public function pushPicture($identityToken, $url, $description = null, $createPost = false)
    // {
    //     $data = [
    //         'request' => [
    //             'push' => [
    //                 'picture' => [
    //                     'url' => $url,
    //                     'create_post' => $createPost
    //                 ]
    //             ]
    //         ]
    //     ];

    //     $this->addInfo($data, 'request/push/picture/description', $description);

    //     return $this->getClient()->post('/push/identities/' . $identityToken . '/facebook/picture.json', $data);
    // }

    // *
    //  * Upload a picture.
    //  *
    //  * @param string $identityToken
    //  * @param string $videoUri
    //  * @param null   $description
    //  * @param bool   $createPost
    //  *
    //  * @see https://docs.oneall.com/api/resources/push/facebook/video/
    //  *
    //  * @return \Oneall\Client\Response

    // public function pushVideo($identityToken, $videoUri, $description = null, $createPost = false)
    // {
    //     $data = [
    //         'request' => [
    //             'push' => [
    //                 'video' => [
    //                     'url' => $videoUri,
    //                     'create_post' => $createPost
    //                 ]
    //             ]
    //         ]
    //     ];

    //     $this->addInfo($data, 'request/push/video/callback_url', $description);

    //     return $this->getClient()->post('/push/identities/' . $identityToken . '/facebook/video.json', $data);
    // }
}
