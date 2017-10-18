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

namespace Oneall\Test\Api\Apis;

use Oneall\Api\Apis\Sharing;
use Oneall\Test\Api\TestingApi;

/**
 * Class SharingTest
 *
 * @package Oneall\Test\Api\Apis
 */
class SharingTest extends TestingApi
{
    /**
     * @var \Oneall\Api\Apis\Sharing
     */
    protected $sut;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        parent::setUp();
        $this->sut = new Sharing($this->client, $this->timeout);
    }

    public function testGetName()
    {
        $this->assertEquals('sharing', $this->sut->getName());
    }

    public function testGetAll()
    {
        $this->client->expects($this->once())
                     ->method('get')
                     ->with('/sharing/pages.json', $this->options)
                     ->willReturn($this->response)
        ;

        $this->assertSame($this->response, $this->sut->getAll($this->options));
    }

    public function testGetPageByToken()
    {
        $this->client->expects($this->once())
                     ->method('get')
                     ->with('/sharing/pages/my-token.json', $this->options)
                     ->willReturn($this->response)
        ;

        $this->assertSame($this->response, $this->sut->getPageByToken('my-token', $this->options));
    }

    public function testGetPageByUrl()
    {
        $this->client->expects($this->once())
                     ->method('get')
                     ->with('/sharing/pages/page.json?page_url=my-url', $this->options)
                     ->willReturn($this->response)
        ;

        $this->assertSame($this->response, $this->sut->getPageByUrl('my-url', $this->options));
    }

    public function testGetMessages()
    {
        $this->client->expects($this->once())
                     ->method('get')
                     ->with('/sharing/messages.json', $this->options)
                     ->willReturn($this->response)
        ;

        $this->assertSame($this->response, $this->sut->getMessages($this->options));
    }

    public function testGetMessagesDetails()
    {
        $this->client->expects($this->once())
                     ->method('get')
                     ->with('/sharing/messages/my-token.json', $this->options)
                     ->willReturn($this->response)
        ;

        $this->assertSame($this->response, $this->sut->getMessageDetails('my-token', $this->options));
    }

    public function testpublish()
    {
        $data = [
            'request' => [
                'sharing_message' => [
                    'publish_for_user' => [
                        'user_token' => 'my-token',
                        'providers' => ['facebook']
                    ],
                    'parts' => [
                        'text' => ['body' => 'my-text'],
                        'flags' => ['enable_tracking' => 1]
                    ]
                ]
            ]
        ];

        $this->client->expects($this->once())
                     ->method('post')
                     ->with('/sharing/messages.json', $data)
                     ->willReturn($this->response)
        ;

        $this->assertSame($this->response, $this->sut->publish('my-token', ['facebook'], 'my-text'));
    }

    public function testpublishWithAllArguments()
    {
        $data = [
            'request' => [
                'sharing_message' => [
                    'publish_for_user' => [
                        'user_token' => 'my-token',
                        'providers' => ['facebook']
                    ],
                    'parts' => [
                        'text' => ['body' => 'my-text'],
                        'video' => ['url' => '#video_url#'],
                        'picture' => ['url' => '#picture_url#'],
                        'link' => [
                            'url' => '#link_url#',
                            'name' => '#link_name#',
                            'caption' => '#link_caption#',
                            'description' => '#link_description#'
                        ],
                        'uploads' => [
                            [
                                'name' => '#upload_file_name#',
                                'data' => '#upload_file_data#'
                            ]
                        ],
                        'flags' => ['enable_tracking' => 0]
                    ]
                ]
            ]
        ];

        $this->client->expects($this->once())
                     ->method('post')
                     ->with('/sharing/messages.json', $data, $this->options)
                     ->willReturn($this->response)
        ;

        $this->assertSame(
            $this->response,
            $this->sut->publish(
                'my-token',
                ['facebook'],
                'my-text',
                '#video_url#',
                '#picture_url#',
                [
                    'url' => '#link_url#',
                    'name' => '#link_name#',
                    'caption' => '#link_caption#',
                    'description' => '#link_description#'
                ],
                [
                    [
                        'name' => '#upload_file_name#',
                        'data' => '#upload_file_data#'
                    ]
                ],
                false,
                $this->options
            )
        );
    }

    public function testRepublish()
    {
        $data = [
            'request' => [
                'sharing_message' => [
                    'publish_for_user' => [
                        'user_token' => 'user-token',
                        'providers' => ['facebook']
                    ],
                ]
            ]
        ];

        $this->client->expects($this->once())
                     ->method('post')
                     ->with('/sharing/messages/message-token.json', $data)
                     ->willReturn($this->response)
        ;

        $this->assertSame($this->response, $this->sut->republish('message-token', 'user-token', ['facebook']));
    }

    public function testRepublishforIndetity()
    {
        $data = [
            'request' => [
                'sharing_message' => [
                    'publish_for_identity' => [
                        'identity_token' => 'identity-token'
                    ],
                ]
            ]
        ];

        $this->client->expects($this->once())
                     ->method('post')
                     ->with('/sharing/messages/message-token.json', $data)
                     ->willReturn($this->response)
        ;

        $this->assertSame(
            $this->response,
            $this->sut->republishForIdentity('message-token', 'identity-token')
        );
    }

    public function testDelete()
    {
        $this->client->expects($this->once())
                     ->method('delete')
                     ->with('/sharing/messages/my-token.json?confirm_deletion=true', $this->options)
                     ->willReturn($this->response)
        ;

        $this->assertSame($this->response, $this->sut->delete('my-token', $this->options));
    }

}
