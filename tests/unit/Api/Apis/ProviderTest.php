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

use Oneall\Api\Apis\Provider;
use Oneall\Test\Api\TestingApi;

/**
 * Class ProviderTest
 *
 * @package Oneall\Test\Api\Apis
 */
class ProviderTest extends TestingApi
{
    /**
     * @var \Oneall\Api\Apis\Provider
     */
    protected $sut;

    /**
     * @var
     */
    protected $provider;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        parent::setUp();
        $this->sut      = new Provider($this->client, $this->timeout);
        $this->provider = $this->getMockForAbstractClass('Oneall\Api\AbstractApi', [], '', false, false, false);
        $this->provider->method('getName')->willReturn('test');

        // ensure only 1 provider "test" is in the registry
        $property = new \ReflectionProperty($this->sut, 'providerApis');
        $property->setAccessible(true);
        $property->setValue($this->sut, ['test' => $this->provider]);
    }

    public function testGetName()
    {
        $this->assertEquals('provider', $this->sut->getName());
    }

    public function testGetAll()
    {
        $this->client->expects($this->once())
                     ->method('get')
                     ->with('/providers.json?' . $this->getDefaultPaginationQuery())
                     ->willReturn($this->response)
        ;

        $this->assertSame($this->response, $this->sut->getAll());
    }

    public function testGetAllWithPagination()
    {
        $this->client->expects($this->once())
                     ->method('get')
                     ->with('/providers.json?' . $this->pagination->build())
                     ->willReturn($this->response)
        ;

        $this->assertSame($this->response, $this->sut->getAll($this->pagination));
    }

    public function testHasProvider()
    {

        $this->assertFalse($this->sut->hasProviderApi('wrong'));
        $this->assertTrue($this->sut->hasProviderApi('test'));
    }

    public function testGetProvider()
    {
        // provider has been init in the setUp method
        $this->assertSame($this->provider, $this->sut->getProviderApi('test'));
    }

    public function testGetProviderWithnonExistingProvider()
    {
        $this->setExpectedException('Oneall\Exception\ProviderApiNotFound');
        $this->sut->getProviderApi('non-existing-provider');
    }

    public function testGetProvidersApiNames()
    {
        $this->assertEquals(['test'], $this->sut->getProvidersApiNames());
    }

    /**
     * @depends testHasProvider
     */
    public function testConstructor()
    {
        $sut = new Provider($this->client, $this->timeout);

        $this->assertTrue($sut->hasProviderApi('facebook'));
        $this->assertTrue($sut->hasProviderApi('steam'));
        $this->assertTrue($sut->hasProviderApi('youtube'));
        $this->assertTrue($sut->hasProviderApi('linkedin'));
        $this->assertTrue($sut->hasProviderApi('twitter'));
        $this->assertTrue($sut->hasProviderApi('pinterest'));

    }
}

