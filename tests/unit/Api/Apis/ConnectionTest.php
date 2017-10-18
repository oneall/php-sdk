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

use Oneall\Api\Apis\Connection;
use Oneall\Test\Api\TestingApi;

/**
 * Class ConnectionTest
 *
 * @package Oneall\Test\Api\Apis
 */
class ConnectionTest extends TestingApi
{
    /**
     * @var \Oneall\Api\Apis\Connection
     */
    protected $sut;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        parent::setUp();
        $this->sut = new Connection($this->client, $this->timeout);
    }

    public function testGetName()
    {
        $this->assertEquals('connection', $this->sut->getName());
    }

    public function testGetAll()
    {
        $this->client->expects($this->once())
                     ->method('get')
                     ->with('/connections.json', $this->options)
                     ->willReturn($this->response)
        ;

        $this->assertSame($this->response, $this->sut->getAll($this->options));
    }

    public function testGet()
    {
        $this->client->expects($this->once())
                     ->method('get')
                     ->with('/connections/my-token.json', $this->options)
                     ->willReturn($this->response)
        ;

        $this->assertSame($this->response, $this->sut->get('my-token', $this->options));
    }
}
