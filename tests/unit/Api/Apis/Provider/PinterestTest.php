<?php

/**
 * @package      Oneall PHP-SDK
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

use Oneall\Api\Apis\Provider\Pinterest;
use Oneall\Test\Api\TestingApi;

/**
 * Class PinterestTest
 *
 * @package unit\Api\Apis\Provider
 */
class PinterestTest extends TestingApi
{
    /**
     * @var \Oneall\Api\Apis\Provider\Pinterest
     */
    protected $sut;

    protected function setUp()
    {
        parent::setUp();
        $this->sut = new Pinterest($this->client, $this->timeout);
    }

    public function testGetName()
    {
        $this->assertEquals('pinterest', $this->sut->getName());
    }

    public function testPostPins()
    {
        $this->client->expects($this->once())
                     ->method('post')
                     ->with('/push/identities/my-token/pinterest/pin.json',
                            [
                                'request' => [
                                    'push' => [
                                        'pin' => [
                                            'board' => 'my/board',
                                            'note' => 'my-note',
                                            'image_url' => 'my-image-uri',
                                            'link' => 'my-link'
                                        ]
                                    ]
                                ]
                            ]
                     )
                     ->willReturn($this->response)
        ;
        $returned = $this->sut->publishPin('my-token', 'my/board', 'my-note', 'my-image-uri', 'my-link');
        $this->assertSame($this->response, $returned);
    }

    public function testPostPinswithoutLinkParam()
    {
        $this->client->expects($this->once())
                     ->method('post')
                     ->with('/push/identities/my-token/pinterest/pin.json',
                            [
                                'request' => [
                                    'push' => [
                                        'pin' => [
                                            'board' => 'my/board',
                                            'note' => 'my-note',
                                            'image_url' => 'my-image-uri',
                                        ]
                                    ]
                                ]
                            ]
                     )
                     ->willReturn($this->response)
        ;
        $returned = $this->sut->publishPin('my-token', 'my/board', 'my-note', 'my-image-uri');
        $this->assertSame($this->response, $returned);
    }

    public function testGetBoardList()
    {
        $this->client->expects($this->once())
                     ->method('get')
                     ->with('/pull/identities/my-token/pinterest/boards.json')
                     ->willReturn($this->response)
        ;

        $this->assertSame($this->response, $this->sut->getBoards('my-token'));
    }
}
