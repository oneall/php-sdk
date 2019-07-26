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
 * Class Youtube
 *
 * This provider is used for all interaction with Youtube provider.
 *
 * @package Oneall\Api\Apis\Provider
 */
class Youtube extends AbstractApi
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'youtube';
    }

    /**
     * Youtube \ List Videos
     *
     * @param string $identityToken
     *
     * @see http://docs.oneall.com/api/resources/pull/youtube/videos/
     *
     * @return \Oneall\Client\Response
     */
    public function pullVideos($identityToken)
    {
        return $this->getClient()->get('/pull/identities/' . $identityToken . '/youtube/videos.json');
    }

    /**
     * Youtube upload a video
     *
     * @param string $identityToken
     * @param string $videoUrl
     * @param string $title
     * @param string|null $description
     * @param string|null $thumbnailUrl
     * @param string|null $callbackUrl
     *
     * @see http://docs.oneall.com/api/resources/push/youtube/video/
     *
     * @return \Oneall\Client\Response
     */
    public function pushVideos(
        $identityToken,
        $videoUrl,
        $title,
        $description = null,
        $thumbnailUrl = null,
        $callbackUrl = null
    )
    {
        $data = [
            'request' => [
                'push' => [
                    'video' => [
                        'video_url' => $videoUrl,
                        'title' => $title
                    ]
                ]
            ]
        ];

        $data = $this->addInfo($data, 'request/push/video/description', $description);
        $data = $this->addInfo($data, 'request/push/video/thumbnail_url', $thumbnailUrl);
        $data = $this->addInfo($data, 'request/push/video/callback_url', $callbackUrl);

        return $this->getClient()->post('/push/identities/' . $identityToken . '/youtube/video.json', $data);
    }
}
