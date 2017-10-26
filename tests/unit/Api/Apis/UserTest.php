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

use Oneall\Api\Apis\User;
use Oneall\Test\Api\TestingApi;

/**
 * Class UserTest
 *
 * @package Oneall\Test\Api\Apis
 */
class UserTest extends TestingApi
{
    /**
     * @var \Oneall\Api\Apis\User
     */
    protected $sut;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        parent::setUp();
        $this->sut = new User($this->client, $this->timeout);
    }

    public function testGetName()
    {
        $this->assertEquals('user', $this->sut->getName());
    }

    public function testGetAll()
    {
        $query = $this->getDefaultPaginationQuery();
        $this->client->expects($this->once())
                     ->method('get')
                     ->with('/users.json?' . $query)
                     ->willReturn($this->response)
        ;

        $this->assertSame($this->response, $this->sut->getAll());
    }

    public function testGetAllWithPagination()
    {
        $this->client->expects($this->once())
                     ->method('get')
                     ->with('/users.json?' . $this->pagination->build())
                     ->willReturn($this->response)
        ;

        $this->assertSame($this->response, $this->sut->getAll($this->pagination));
    }

    public function testGet()
    {
        $this->client->expects($this->once())
                     ->method('get')
                     ->with('/users/my-token.json')
                     ->willReturn($this->response)
        ;

        $this->assertSame($this->response, $this->sut->get('my-token'));
    }

    public function testCreateUser()
    {
        $data = [
            "request" => [
                "user" => [
                    "action" => "import_from_access_token",
                    "identity" => [
                        "source" => [
                            "key" => 'provider-key',
                            "access_token" => [
                                "key" => 'access-token',
                            ]
                        ]
                    ]
                ]
            ]
        ];
        $this->client->expects($this->once())
                     ->method('put')
                     ->with('/users.json', $data)
                     ->willReturn($this->response)
        ;
        $this->assertSame($this->response, $this->sut->createUser('provider-key', 'access-token'));
    }

    public function testCreateUserWithAllArgs()
    {
        $data = [
            "request" => [
                "user" => [
                    "action" => "import_from_access_token",
                    'user_token' => 'user_token',
                    "identity" => [
                        "source" => [
                            "key" => 'provider-key',
                            "access_token" => [
                                "key" => 'access-token',
                                "secret" => 'access-token-secret',
                            ]
                        ]
                    ]
                ]
            ]
        ];
        $this->client->expects($this->once())
                     ->method('put')
                     ->with('/users.json', $data)
                     ->willReturn($this->response)
        ;

        $this->assertSame(
            $this->response,
            $this->sut->createUser('provider-key', 'access-token', 'user_token', 'access-token-secret')
        );
    }

    public function testDelete()
    {

        $this->client->expects($this->once())
                     ->method('delete')
                     ->with('/users/my-token.json?confirm_deletion=true')
                     ->willReturn($this->response)
        ;

        $this->assertSame($this->response, $this->sut->delete('my-token'));
    }

    public function testGetContacts()
    {

        $this->client->expects($this->once())
                     ->method('get')
                     ->with('/users/my-token/contacts.json')
                     ->willReturn($this->response)
        ;

        $this->assertSame($this->response, $this->sut->getContacts('my-token'));
    }

    public function testGetContactsWithCache()
    {

        $this->client->expects($this->once())
                     ->method('get')
                     ->with('/users/my-token/contacts.json?disable_cache=true')
                     ->willReturn($this->response)
        ;

        $this->assertSame($this->response, $this->sut->getContacts('my-token', true));
    }

    public function testPublish()
    {
        $data = [
            "request" => [
                "message" => [
                    "providers" => ['facebook'],
                    "parts" => [
                        "text" => ["body" => 'my-text'],
                    ]
                ]
            ]
        ];

        $this->client->expects($this->once())->method('post')->with('/users/my-token/publish.json',
                                                                    $data)->willReturn($this->response)
        ;

        $this->assertSame($this->response, $this->sut->publish('my-token', ['facebook'], 'my-text'));
    }

    public function testPublishWithAllArgs()
    {
        $uploads = [
            [
                "name" => "upload-name",
                "data" => "upload-data"
            ]
        ];
        $link    = [
            'url' => 'link-url',
            'name' => 'link-name',
            'caption' => 'link-caption',
            'description' => 'link-description',
        ];

        $data = [
            "request" => [
                "message" => [
                    "providers" => ['facebook'],
                    "parts" => [
                        "text" => ["body" => 'text'],
                        'video' => ['url' => 'video-url'],
                        'picture' => ['url' => 'picture-url'],
                        'link' => $link,
                        'uploads' => $uploads,
                    ]
                ]
            ]
        ];

        $this->client->expects($this->once())
                     ->method('post')
                     ->with('/users/my-token/publish.json', $data)
                     ->willReturn($this->response)
        ;

        $this->assertSame(
            $this->response,
            $this->sut->publish('my-token', ['facebook'], 'text', 'video-url', 'picture-url', $link, $uploads)
        );
    }
}
