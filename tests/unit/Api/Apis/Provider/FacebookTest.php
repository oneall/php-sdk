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

use Oneall\Api\Apis\Provider\Facebook;
use Oneall\Test\Api\TestingApi;

/**
 * Class FacebookTest
 *
 * @package unit\Api\Apis\Provider
 */
class FacebookTest extends TestingApi
{
    /**
     * @var \Oneall\Api\Apis\Provider\Facebook
     */
    protected $sut;

    protected function setUp()
    {
        parent::setUp();
        $this->sut = new Facebook($this->client, $this->timeout);
    }

    public function testGetName()
    {
        $this->assertEquals('facebook', $this->sut->getName());
    }

    public function testGetPosts()
    {
        $this->client->expects($this->once())
                     ->method('get')
                     ->with('/identities/my-token/facebook/posts.json?' . $this->getDefaultPaginationQuery())
                     ->willReturn($this->response)
        ;

        $this->assertSame($this->response, $this->sut->getPosts('my-token'));
    }

    public function testGetPostsWithPagination()
    {
        $this->client->expects($this->once())
                     ->method('get')
                     ->with('/identities/my-token/facebook/posts.json?' . $this->pagination->build())
                     ->willReturn($this->response)
        ;

        $this->assertSame($this->response, $this->sut->getPosts('my-token', $this->pagination));
    }

    public function testGetPages()
    {
        $this->client->expects($this->once())
                     ->method('get')
                     ->with('/providers/facebook/pages.json?' . $this->getDefaultPaginationQuery())
                     ->willReturn($this->response)
        ;

        $this->assertSame($this->response, $this->sut->getPages());
    }

    public function testGetPageswithPagination()
    {
        $this->client->expects($this->once())
                     ->method('get')
                     ->with('/providers/facebook/pages.json?' . $this->pagination->build())
                     ->willReturn($this->response)
        ;

        $this->assertSame($this->response, $this->sut->getPages($this->pagination));
    }

    public function testPublish()
    {
        $token   = 'my-token';
        $text    = 'my-text';
        $picture = 'my-picture';
        $link    = ['url' => 'my-link'];

        $data = [
            'request' => [
                'page_message' => [
                    'parts' => [
                        'text' => ['body' => $text],
                        'picture' => ['url' => $picture],
                        'link' => $link,
                    ]
                ]
            ]
        ];

        $this->client->expects($this->once())
                     ->method('post')
                     ->with('/providers/facebook/pages/my-token/publish.json', $data)
                     ->willReturn($this->response)
        ;

        $this->assertSame($this->response, $this->sut->publish($token, $text, $link, $picture));
    }

    public function testPublishOnlyText()
    {
        $token = 'my-token';
        $text  = 'my-text';
        $data  = [
            'request' => [
                'page_message' => [
                    'parts' => [
                        'text' => ['body' => $text],
                        'picture' => [],
                        'link' => [],
                    ]
                ]
            ]
        ];

        $this->client->expects($this->once())
                     ->method('post')
                     ->with('/providers/facebook/pages/my-token/publish.json', $data)
                     ->willReturn($this->response)
        ;

        $this->assertSame($this->response, $this->sut->publish($token, $text));
    }

    public function testPublishWithourAnyDataToPublish()
    {
        $this->setExpectedException('Oneall\Exception\BadMethodCallException');
        $this->assertSame($this->response, $this->sut->publish('my-token', $noText = null, $noLink = []));
    }
}
