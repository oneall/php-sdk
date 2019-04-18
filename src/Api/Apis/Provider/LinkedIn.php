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
 * Class LinkedIn
 *
 * @package Oneall\Api\Apis\Provider
 */
class LinkedIn extends AbstractApi
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'linkedin';
    }

    // ****************
    // Pull API
    // ****************

    /**
     * Pull Companies
     *
     * @param string $identityToken
     *
     * @see http://docs.oneall.com/api/resources/pull/linkedin/companies/
     *
     * @return \Oneall\Client\Response
     */
    public function pullCompanies($identityToken)
    {
        return $this->getClient()->get('/pull/identities/' . $identityToken . '/linkedin/companies.json' . $data);
    }

    /**
     * Company Posts
     *
     * @param string $identityToken
     *
     * @see http://docs.oneall.com/api/resources/pull/linkedin/company/posts/
     *
     * @return \Oneall\Client\Response
     */
    public function pullCompanyPost($identityToken, $companyId, $num_posts = 50, $page = 1)
    {
        $data = '?num_posts=' . $num_posts;
        $data .= !empty($page) && is_int($page) ? '&page=' . $page : '';

        return $this->getClient()->get('/pull/identities/' . $identityToken . '/linkedin/company/' . $companyId . '/posts.json' . $data);
    }

    // ****************
    // Push API
    // ****************

    /**
     * Push User Post
     *
     * @param string      $identityToken
     * @param string      $link
     * @param string|null $title
     * @param string|null $description
     * @param string|null $message
     * @param string|null $pictureUrl
     *
     * @see http://docs.oneall.com/api/resources/push/linkedin/post/
     *
     * @return \Oneall\Client\Response
     */
    public function pushPost(
        $identityToken,
        $link,
        $title = null,
        $description = null,
        $message = null,
        $pictureUrl = null
    )
    {
        $data = [
            "request" => [
                "push" => [
                    "post" => [
                        "link" => $link
                    ]
                ]
            ]
        ];

        $this->addInfo($data, "request/push/post/description", $description);
        $this->addInfo($data, "request/push/post/message", $message);
        $this->addInfo($data, "request/push/post/title", $title);
        $this->addInfo($data, "request/push/post/picture", $pictureUrl);

        return $this->getClient()->post('/push/identities/' . $identityToken . '/linkedin/post.json', $data);
    }

    /**
     * Push Post company page
     *
     * @param string      $identityToken
     * @param string      $link
     * @param string      $companyId
     * @param string|null $title
     * @param string|null $description
     * @param string|null $message
     * @param string|null $pictureUrl
     *
     * @see http://docs.oneall.com/api/resources/push/linkedin/post/
     *
     * @return \Oneall\Client\Response
     */
    public function pushCompanyPost(
        $identityToken,
        $link,
        $companyId,
        $title = null,
        $description = null,
        $message = null,
        $pictureUrl = null
    )
    {
        $data = [
            "request" => [
                "push" => [
                    "post" => [
                        "company" => $companyId,
                        "link" => $link
                    ]
                ]
            ]
        ];

        $this->addInfo($data, "request/push/post/description", $description);
        $this->addInfo($data, "request/push/post/message", $message);
        $this->addInfo($data, "request/push/post/title", $title);
        $this->addInfo($data, "request/push/post/picture", $pictureUrl);

        return $this->getClient()->post('/push/identities/' . $identityToken . '/linkedin/company/post.json', $data);
    }
}
