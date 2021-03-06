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

use Oneall\Api\Apis\Sso;
use Oneall\Test\Api\TestingApi;

/**
 * Class SsoTest
 *
 * @package Oneall\Test\Api\Apis
 */
class SsoTest extends TestingApi
{
    /**
     * @var \Oneall\Api\Apis\Sso
     */
    protected $sut;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        parent::setUp();
        $this->sut = new Sso($this->client, $this->timeout);
    }

    public function testGetName()
    {
        $this->assertEquals('sso', $this->sut->getName());
    }

    public function testGetAll()
    {
        $this->client->expects($this->once())
                     ->method('get')
                     ->with('/sso/sessions.json?' . $this->getDefaultPaginationQuery())
                     ->willReturn($this->response)
        ;

        $this->assertSame($this->response, $this->sut->getAll());
    }

    public function testGetAllWithPagination()
    {
        $this->client->expects($this->once())
                     ->method('get')
                     ->with('/sso/sessions.json?' . $this->pagination->build())
                     ->willReturn($this->response)
        ;

        $this->assertSame($this->response, $this->sut->getAll($this->pagination));
    }

    public function testGet()
    {
        $this->client->expects($this->once())
                     ->method('get')
                     ->with('/sso/sessions/my-token.json')
                     ->willReturn($this->response)
        ;

        $this->assertSame($this->response, $this->sut->get('my-token'));
    }

    public function testDelete()
    {
        $this->client->expects($this->once())
                     ->method('delete')
                     ->with('/sso/sessions/my-token.json?confirm_deletion=true')
                     ->willReturn($this->response)
        ;

        $this->assertSame($this->response, $this->sut->delete('my-token'));
    }

    public function testStartIdentitySession()
    {
        $data = ['request' => ['sso_session' => []]];

        $this->client->expects($this->once())
                     ->method('put')
                     ->with('/sso/sessions/identities/my-token.json', $data)
                     ->willReturn($this->response)
        ;

        $this->assertSame($this->response, $this->sut->startIdentitySession('my-token'));
    }

    public function testStartIdentitySessionwithAllArgs()
    {
        $data = [
            'request' => [
                'sso_session' => [
                    'top_realm' => 'top_realm',
                    'sub_realm' => 'sub_realm',
                    'lifetime' => 'lifetime',
                ]
            ]
        ];

        $this->client->expects($this->once())
                     ->method('put')
                     ->with('/sso/sessions/identities/my-token.json', $data)
                     ->willReturn($this->response)
        ;

        $this->assertSame(
            $this->response,
            $this->sut->startIdentitySession('my-token', 'top_realm', 'sub_realm', 'lifetime')
        );
    }

    public function testReadIdentitySession()
    {
        $this->client->expects($this->once())
                     ->method('get')
                     ->with('/sso/sessions/identities/my-token.json')
                     ->willReturn($this->response)
        ;

        $this->assertSame($this->response, $this->sut->readIdentitySession('my-token'));
    }

    public function testdestroyIdentitySession()
    {
        $this->client->expects($this->once())
                     ->method('delete')
                     ->with('/sso/sessions/identities/my-token.json?confirm_deletion=true')
                     ->willReturn($this->response)
        ;

        $this->assertSame($this->response, $this->sut->destroyIdentitySession('my-token'));
    }
}
