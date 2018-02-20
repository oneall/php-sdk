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

namespace Oneall\Api;

use Oneall\Test\Api\TestingApi;
use Oneall\Test\PhpUnitHelperTrait;

/**
 * Class AbstractApiTest
 *
 * @package Oneall\Api
 */
class AbstractApiTest extends TestingApi
{
    use PhpUnitHelperTrait;

    /**
     *  Subject class
     */
    const SUBJECT = '\Oneall\Api\AbstractApi';

    /**
     * @var \Oneall\Api\TestingAbstractApi
     */
    protected $sut;

    /**
     * @var \Oneall\Client\ClientInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $client;

    protected function setUp()
    {
        parent::setUp();
        $this->sut    = new TestingAbstractApi($this->client);
        $this->client = $this->getMockForAbstractClass('\Oneall\Client\ClientInterface');
    }

    /**
     * @param $data
     * @param $expected
     * @param $path
     * @param $value
     *
     * @dataProvider provideTestAddInfo
     */
    public function testAddInfo($expected, $data, $path, $value)
    {
        $this->assertEquals($expected, $this->sut->addInfo($data, $path, $value));
    }

    public function testGetTimeout()
    {
        $this->setProperty($this->sut, 'timeout', 123456);
        $this->assertSame(123456, $this->invoke($this->sut, 'getTimeout'));
    }

    public function testGetClient()
    {
        $this->setProperty($this->sut, 'client', $this->client);

        $this->assertSame($this->client, $this->invoke($this->sut, 'getClient'));
    }

    /**
     * @depends testGetClient
     * @depends testGetTimeout
     */
    public function testConstructor()
    {
        $sut = new TestingAbstractApi($this->client, 123456789);
        $this->assertSame($this->client, $this->invoke($sut, 'getClient'));
        $this->assertSame(123456789, $this->invoke($sut, 'getTimeout'));
    }

    /**
     * @return array
     */
    public function provideTestAddInfo()
    {
        $array                 = ['a' => ['b1' => 1, 'b2' => 2,]];
        $expected              = ['a' => ['b1' => 1, 'b2' => 2, 'b' => ['c' => 'ok']]];
        $expected2             = ['a' => ['b1' => 1, 'b2' => 2], 'c' => 'ok'];
        $array2                = $array;
        $array2['a']['b']['c'] = 'will be deleted';

        return [
            [$expected, $array, 'a/b/c', 'ok'],
            [$expected, $array, '///a////b///c///', 'ok'],
            [$expected, $array2, '/a/b/c/', 'ok'],
            [$expected2, $array, '///c//', 'ok'],
        ];
    }
}

/**
 * Class TestingAbstractApi
 *
 * This class is only use for tests. It's not a good practicve, but it's much more easier to tests its methods.
 */
class TestingAbstractApi extends AbstractApi
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'testing-abstract-api';
    }

    public function addInfo(array $array, $path, $value)
    {
        return parent::addInfo($array, $path, $value);
    }

}
