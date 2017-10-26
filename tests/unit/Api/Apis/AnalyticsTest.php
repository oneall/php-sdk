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

use Oneall\Api\Apis\Analytics;
use Oneall\Test\Api\TestingApi;

class AnalyticsTest extends TestingApi
{
    /**
     * @var \Oneall\Api\Apis\Analytics
     */
    protected $sut;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        parent::setUp();
        $this->sut = new Analytics($this->client, $this->timeout);
    }

    public function testGetName()
    {
        $this->assertEquals('analytics', $this->sut->getName());
    }

    public function testGetAllWithoutToken()
    {
        $this->client->expects($this->once())
                     ->method('get')
                     ->with('/sharing/analytics/snapshots.json?' . $this->getDefaultPaginationQuery())
                     ->willReturn($this->response)
        ;

        $this->assertSame($this->response, $this->sut->getAll());
    }

    public function testGetAllWithOptions()
    {
        $this->client->expects($this->once())
                     ->method('get')
                     ->with('/sharing/analytics/snapshots.json?' . $this->pagination->build() . '&identity_token=a&user_token=b')
                     ->willReturn($this->response)
        ;

        $this->assertSame($this->response, $this->sut->getAll($this->pagination, 'a', 'b'));
    }

    public function testInitiate()
    {
        $data = [
            'request' => [
                'analytics' => [
                    'sharing' => [
                        'sharing_message_token' => 'my-token',
                        'pingback_uri' => 'my-uri'
                    ]
                ]
            ]
        ];
        $this->client->expects($this->once())
                     ->method('put')
                     ->with('/sharing/analytics/snapshots.json', $data)
                     ->willReturn($this->response)
        ;

        $this->assertSame($this->response, $this->sut->initiate('my-token', 'my-uri'));
    }

    public function testGet()
    {
        $this->client->expects($this->once())
                     ->method('get')
                     ->with('/sharing/analytics/snapshots/my-token.json')
                     ->willReturn($this->response)
        ;

        $this->assertSame($this->response, $this->sut->get('my-token'));
    }

    public function testDelete()
    {
        $this->client->expects($this->once())
                     ->method('delete')
                     ->with('/sharing/analytics/snapshots/my-token.json?confirm_deletion=true')
                     ->willReturn($this->response)
        ;

        $this->assertSame($this->response, $this->sut->delete('my-token'));
    }
}
