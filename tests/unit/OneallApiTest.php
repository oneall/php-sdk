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

namespace Oneall\Test;

use Oneall\Api\Registry;
use Oneall\OneallApi;

/**
 * Class OneallApiTest
 *
 * @package Oneall\Test
 */
class OneallApiTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Oneall\OneallApi
     */
    protected $sut;

    /**
     * @var \Oneall\Client\ClientInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $client;
    /**
     * @var \Oneall\Client\ProxyConfiguration|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $proxy;
    /**
     * @var \Oneall\Api\Registry|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $registry;

    protected function setUp()
    {
        parent::setUp();
        new Registry();
        $methods        = ['get', 'add'];
        $this->client   = $this->getMockForAbstractClass('\Oneall\Client\ClientInterface', [], '', false, false);
        $this->proxy    = $this->getMockForAbstractClass('\Oneall\Client\ProxyConfiguration', [], '', false, false);
        $this->registry = $this->getMockForAbstractClass('\Oneall\Api\Registry', [], '', false, false, false, $methods);

        $this->sut = new OneallApi($this->client, $this->proxy, $this->registry);
    }

    public function testGetter()
    {

        $this->setObjectProperty($this->sut, 'client', null);
        $this->setObjectProperty($this->sut, 'proxy', null);
        $this->setObjectProperty($this->sut, 'registry', null);

        $this->assertEquals(null, $this->sut->getProxy());
        $this->assertSame($this->sut, $this->sut->setProxy($this->proxy));
        $this->assertSame($this->proxy, $this->sut->getProxy());

        $this->assertEquals(null, $this->sut->getClient());
        $this->assertSame($this->sut, $this->sut->setClient($this->client));
        $this->assertSame($this->client, $this->sut->getClient());

        $this->assertEquals(null, $this->sut->getRegistry());
        $this->assertSame($this->sut, $this->sut->setRegistry($this->registry));
        $this->assertSame($this->registry, $this->sut->getRegistry());
    }

    public function testGetConnectionApi()
    {
        $this->registry->expects($this->once())->method('get')->willReturn(OneallApi::API_CONNECTION);
        $this->sut->getConnectionApi();
    }

    public function testGetIdentityApi()
    {
        $this->registry->expects($this->once())->method('get')->willReturn(OneallApi::API_IDENTITY);
        $this->sut->getIdentityApi();
    }

    public function testGetProviderApi()
    {
        $this->registry->expects($this->once())->method('get')->willReturn(OneallApi::API_PROVIDER);
        $this->sut->getProviderApi();
    }

    public function testGetSharingApi()
    {
        $this->registry->expects($this->once())->method('get')->willReturn(OneallApi::API_SHARING);
        $this->sut->getSharingApi();
    }

    public function testGetshorturlApi()
    {
        $this->registry->expects($this->once())->method('get')->willReturn(OneallApi::API_SHORTURL);
        $this->sut->getShorturlApi();
    }

    public function testGetSsoApi()
    {
        $this->registry->expects($this->once())->method('get')->willReturn(OneallApi::API_SSO);
        $this->sut->getSsoApi();
    }

    public function testGetStorageApi()
    {
        $this->registry->expects($this->once())->method('get')->willReturn(OneallApi::API_STORAGE);
        $this->sut->getStorageApi();
    }

    public function testGetUserApi()
    {
        $this->registry->expects($this->once())->method('get')->willReturn(OneallApi::API_USER);
        $this->sut->getUserApi();
    }

    protected function buildApi($name)
    {
        $api = $this->getMockForAbstractClass('Oneall\Api\AbstractApi', [], '', false, false);
        $api->method('getName')->willReturn($name);

        return $name;
    }

    protected function setObjectProperty($object, $property, $value)
    {
        $reflection = new \ReflectionProperty($object, $property);
        $reflection->setAccessible(true);
        $reflection->setValue($object, $value);
    }

    /**
     * @depends testGetConnectionApi
     * @depends testGetIdentityApi
     * @depends testGetProviderApi
     * @depends testGetSharingApi
     * @depends testGetSsoApi
     * @depends testGetStorageApi
     * @depends testGetUserApi
     */
    public function testConstructor()
    {
        $sut = new OneallApi($this->client, $this->proxy);
        $this->assertInstanceOf('\Oneall\Api\Apis\Connection', $sut->getConnectionApi());
        $this->assertInstanceOf('\Oneall\Api\Apis\Identity', $sut->getIdentityApi());
        $this->assertInstanceOf('\Oneall\Api\Apis\Provider', $sut->getProviderApi());
        $this->assertInstanceOf('\Oneall\Api\Apis\Sharing', $sut->getSharingApi());
        $this->assertInstanceOf('\Oneall\Api\Apis\ShortUrl', $sut->getShortUrlApi());
        $this->assertInstanceOf('\Oneall\Api\Apis\Sso', $sut->getSsoApi());
        $this->assertInstanceOf('\Oneall\Api\Apis\Storage', $sut->getStorageApi());
        $this->assertInstanceOf('\Oneall\Api\Apis\User', $sut->getUserApi());
    }
}
