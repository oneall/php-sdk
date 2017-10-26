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

use Oneall\Api\Apis\Identity;
use Oneall\Test\Api\TestingApi;

/**
 * Class IdentityTest
 *
 * @package Oneall\Test\Api\Apis
 */
class IdentityTest extends TestingApi
{
    /**
     * @var \Oneall\Api\Apis\Identity
     */
    protected $sut;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        parent::setUp();
        $this->sut = new Identity($this->client, $this->timeout);
    }

    public function testGetName()
    {
        $this->assertEquals('identity', $this->sut->getName());
    }

    public function testGetAll()
    {
        $this->client->expects($this->once())
                     ->method('get')
                     ->with('/identities.json?' . $this->getDefaultPaginationQuery())
                     ->willReturn($this->response)
        ;

        $this->assertSame($this->response, $this->sut->getAll());
    }

    public function testGetAllwithPagination()
    {
        $this->client->expects($this->once())
                     ->method('get')
                     ->with('/identities.json?' . $this->pagination->build())
                     ->willReturn($this->response)
        ;

        $this->assertSame($this->response, $this->sut->getAll($this->pagination));
    }

    public function testGet()
    {
        $this->client->expects($this->once())
                     ->method('get')
                     ->with('/identities/my-token.json')
                     ->willReturn($this->response)
        ;

        $this->assertSame($this->response, $this->sut->get('my-token'));
    }

    public function testDelete()
    {
        $this->client->expects($this->once())
                     ->method('delete')
                     ->with('/identities/my-token.json?confirm_deletion=true')
                     ->willReturn($this->response)
        ;

        $this->assertSame($this->response, $this->sut->delete('my-token'));
    }

    public function testRelink()
    {
        $data = [
            'request' => [
                'user' => [
                    'user_token' => 'user-token'
                ]
            ]
        ];

        $this->client->expects($this->once())
                     ->method('put')
                     ->with('/identities/my-token/link.json', $data)
                     ->willReturn($this->response)
        ;

        $this->assertSame($this->response, $this->sut->relink('my-token', 'user-token'));
    }

    public function testSynchronizeWithDefaultValue()
    {
        $data = [
            'request' => [
                'synchronize' => [
                    'update_user_data' => true,
                    'force_token_update' => false,
                ]
            ]
        ];

        $this->client->expects($this->once())
                     ->method('put')
                     ->with('/identities/my-token/synchronize.json', $data)
                     ->willReturn($this->response)
        ;

        $this->assertSame($this->response, $this->sut->synchronize('my-token'));
    }

    public function testSynchronizeWithTrueValues()
    {
        $data = [
            'request' => [
                'synchronize' => [
                    'update_user_data' => true,
                    'force_token_update' => true,
                ]
            ]
        ];

        $this->client->expects($this->once())
                     ->method('put')
                     ->with('/identities/my-token/synchronize.json', $data)
                     ->willReturn($this->response)
        ;

        $this->assertSame($this->response, $this->sut->synchronize('my-token', true, true));
    }

    public function testSynchronizeWithFalseValues()
    {
        $data = [
            'request' => [
                'synchronize' => [
                    'update_user_data' => false,
                    'force_token_update' => false,
                ]
            ]
        ];

        $this->client->expects($this->once())
                     ->method('put')
                     ->with('/identities/my-token/synchronize.json', $data)
                     ->willReturn($this->response)
        ;

        $this->assertSame($this->response, $this->sut->synchronize('my-token', false, false));
    }

    public function testGetContacts()
    {
        $this->client->expects($this->once())
                     ->method('get')
                     ->with('/identities/my-token/contacts.json?disable_cache=false&' . $this->getDefaultPaginationQuery())
                     ->willReturn($this->response)
        ;

        $this->assertSame($this->response, $this->sut->getContacts('my-token'));
    }

    public function testGetContactsWithOptions()
    {
        $this->client->expects($this->once())
                     ->method('get')
                     ->with('/identities/my-token/contacts.json?disable_cache=true&' . $this->pagination->build())
                     ->willReturn($this->response)
        ;

        $this->assertSame($this->response, $this->sut->getContacts('my-token', $this->pagination, true));
    }
}
