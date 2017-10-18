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

use Oneall\Api\Apis\Storage;
use Oneall\Test\Api\TestingApi;

/**
 * Class StorageTest
 *
 * @package Oneall\Test\Api\Apis
 */
class StorageTest extends TestingApi
{
    /**
     * @var \Oneall\Api\Apis\Storage
     */
    protected $sut;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        parent::setUp();
        $this->sut = new Storage($this->client, $this->timeout);
    }

    public function testGetName()
    {
        $this->assertEquals('storage', $this->sut->getName());
    }

    public function testCreateUserWithoutIdentity()
    {
        $data = [
            'request' => [
                'user' => [
                    'externalid' => 123,
                    'login' => 'my-login',
                    'password' => 'my-password',
                    'identity' => []
                ]
            ]
        ];

        $this->client->expects($this->once())
                     ->method('post')
                     ->with('/storage/users.json', $data)
                     ->willReturn($this->response)
        ;

        $this->assertSame($this->response, $this->sut->createUser([], 123, 'my-login', 'my-password'));
    }

    public function testCreateUserWithIdentity()
    {
        $identity = [
            'name' => [
                'givenName' => '#givenName#',
                'familyName' => '#familyName#'
            ],
            'gender' => '#gender#'
        ];

        $data = [
            'request' => [
                'user' => [
                    'externalid' => 123,
                    'login' => 'my-login',
                    'password' => 'my-password',
                    'identity' => $identity
                ]
            ]
        ];

        $this->client->expects($this->once())
                     ->method('post')
                     ->with('/storage/users.json', $data, $this->options)
                     ->willReturn($this->response)
        ;

        $options = $this->options;
        $this->assertSame($this->response, $this->sut->createUser($identity, 123, 'my-login', 'my-password', $options));
    }

    public function testUpdateUserwithoutAnyData()
    {
        $this->client->expects($this->never())->method('post');
        $this->assertEquals(null, $this->sut->updateUser('my-token'));
    }

    public function testUpdateUserWithexternalid()
    {

        $data = [
            'request' => [
                'update_mode' => 'replace',
                'user' => [
                    'externalid' => 123
                ]
            ]
        ];

        $this->client->expects($this->once())
                     ->method('put')
                     ->with('/storage/users/my-token.json', $data)
                     ->willReturn($this->response)
        ;

        $this->assertSame($this->response, $this->sut->updateUser('my-token', 123));
    }

    public function testUpdateUserWithAllArgs()
    {
        $identity = [
            'name' => [
                'givenName' => '#givenName#',
                'familyName' => '#familyName#'
            ],
            'gender' => '#gender#'
        ];

        $data = [
            'request' => [
                'update_mode' => 'append',
                'user' => [
                    'externalid' => 123,
                    'login' => 'my-login',
                    'password' => 'my-password',
                    'identity' => $identity,
                ]
            ]
        ];

        $this->client->expects($this->once())
                     ->method('put')
                     ->with('/storage/users/my-token.json', $data, $this->options)
                     ->willReturn($this->response)
        ;

        $this->assertSame(
            $this->response,
            $this->sut->updateUser('my-token', 123, 'my-login', 'my-password', $identity, Storage::MODE_UPDATE_APPEND,
                                   $this->options)
        );
    }

    public function testMapUserAccount()
    {
        $data = [
            "request" => [
                "user" => [
                    "externalid" => 123,
                ]
            ]
        ];

        $this->client->expects($this->once())
                     ->method('post')
                     ->with('/storage/users/my-token.json', $data)
                     ->willReturn($this->response)
        ;

        $this->assertSame($this->response, $this->sut->mapUserAccount('my-token', 123));
    }

    public function testLookupById()
    {
        $data = [
            "request" => [
                "user" => [
                    "externalid" => 123,
                ]
            ]
        ];

        $this->client->expects($this->once())
                     ->method('post')
                     ->with('/storage/users/user/lookup.json', $data, $this->options)
                     ->willReturn($this->response)
        ;

        $this->assertSame($this->response, $this->sut->lookUpById(123, $this->options));
    }

    public function testlookUpByCredentials()
    {
        $data = [
            "request" => [
                "user" => [
                    'login' => 'my-login',
                    'password' => 'my-password',
                ]
            ]
        ];

        $this->client->expects($this->once())
                     ->method('post')
                     ->with('/storage/users/user/lookup.json', $data, $this->options)
                     ->willReturn($this->response)
        ;

        $this->assertSame($this->response, $this->sut->lookUpByCredentials('my-login', 'my-password', $this->options));
    }

}
