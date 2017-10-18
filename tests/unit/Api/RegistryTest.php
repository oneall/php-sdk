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

/**
 * Class RegistryTest
 *
 * @package Oneall\Api
 */
class RegistryTest extends TestingApi
{
    /**
     *  Subject class
     */
    const SUBJECT = '\Oneall\Api\Registry';

    /**
     * @var \Oneall\Api\Registry
     */
    protected $sut;

    /**
     * @var \Oneall\Api\AbstractApi|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $api;

    /**
     * @var string
     */
    protected $apiName = 'test-api';

    protected function setUp()
    {
        parent::setUp();
        $this->sut = new Registry();

        // configure our registry with one fake api
        $this->api = $this->buildApi($this->apiName);

        // add our api in the registry
        $reflection = new \ReflectionProperty($this->sut, 'apis');
        $reflection->setAccessible(true);
        $reflection->setValue($this->sut, [$this->api->getName() => $this->api]);
    }

    public function testHas()
    {
        $this->assertTrue($this->sut->has($this->apiName));
        $this->assertfalse($this->sut->has('fake-api-name'));
    }

    public function testGet()
    {
        $this->assertSame($this->api, $this->sut->get($this->apiName));
    }

    public function testGetWrongApi()
    {
        $this->setExpectedException('Oneall\Exception\ApiNotFound');
        $this->sut->get('fake-name');
    }

    /**
     * @depends testGet
     * @depends testGetWrongApi
     */
    public function testAdd()
    {
        $new = $this->buildApi('new');
        $this->assertSame($this->sut, $this->sut->add($new));
        $this->assertSame($new, $this->sut->get('new'));

        $newWithSameName = $this->buildApi('new');
        $this->assertSame($this->sut, $this->sut->add($newWithSameName));
        $this->assertSame($newWithSameName, $this->sut->get('new'), 'test if add override existing api');
    }

    /**
     * @param $name
     *
     * @return \PHPUnit_Framework_MockObject_MockObject|AbstractApi
     */
    protected function buildApi($name)
    {
        $api = $this->getMockForAbstractClass('\Oneall\Api\AbstractApi', [], '', false, false, false);
        $api->method('getName')->willReturn($name);

        return $api;
    }
}
