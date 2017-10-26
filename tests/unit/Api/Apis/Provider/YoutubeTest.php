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

namespace unit\Api\Apis\Provider;

use Oneall\Api\Apis\Provider\Youtube;
use Oneall\Test\Api\TestingApi;

/**
 * Class YoutubeTest
 *
 * @package unit\Api\Apis\Provider
 */
class YoutubeTest extends TestingApi
{
    /**
     * @var \Oneall\Api\Apis\Provider\Youtube
     */
    protected $sut;

    protected function setUp()
    {
        parent::setUp();
        $this->sut = new Youtube($this->client, $this->timeout);
    }

    public function testGetName()
    {
        $this->assertEquals('youtube', $this->sut->getName());
    }

    public function testGetPosts()
    {
        $this->client->expects($this->once())
                     ->method('get')
                     ->with('/identities/my-token/youtube/videos.json')
                     ->willReturn($this->response)
        ;

        $this->assertSame($this->response, $this->sut->getVideos('my-token'));
    }

}
