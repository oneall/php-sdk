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

namespace Oneall\Test\Client;

use Oneall\Test\PhpUnitHelperTrait;

/**
 * Class AbstractClientTest
 *
 * @package Oneall\Test\Client
 */
class AbstractClientTest extends \PHPUnit_Framework_TestCase
{
    use PhpUnitHelperTrait;
    
    /**
     * @var \Oneall\Client\AbstractClient|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $sut;

    /**
     * Current sut fake scheme
     *
     * @var string
     */
    protected $scheme = 'ftp';

    /**
     *
     */
    protected function setUp()
    {
        parent::setUp();

        $this->sut = $this->getMockForAbstractClass('Oneall\Client\AbstractClient', [], '', false, false);
        $this->sut->method('getScheme')->willReturn('ftp');
    }

    public function test()
    {
        $this->sut;
        $this->assertTrue(true);
    }

    public function testGetterSetter()
    {
        $this->setProperty($this->sut,'subDomain', 'my-subDomain');
        $this->setProperty($this->sut,'baseDomain', 'my-baseDomain');
        $this->setProperty($this->sut,'isSecure', true);
        $this->setProperty($this->sut,'timeout', 123);
        $this->setProperty($this->sut,'publicKey', 'my-publicKey');
        $this->setProperty($this->sut,'privateKey', 'my-privateKey');

        // rtesting getters
        $this->assertEquals('my-subDomain', $this->sut->getSubDomain());
        $this->assertEquals('my-baseDomain', $this->sut->getBaseDomain());
        $this->assertEquals(true, $this->sut->isSecure());
        $this->assertEquals(123, $this->sut->getTimeout());
        $this->assertEquals('my-publicKey', $this->sut->getPublicKey());
        $this->assertEquals('my-privateKey', $this->sut->getPrivateKey());

        // tests setters
        $this->assertEquals($this->sut, $this->sut->setBaseDomain('new-base-domain'));
        $this->assertEquals($this->sut, $this->sut->setIsSecure(false));
        $this->assertEquals($this->sut, $this->sut->setTimeout(123456));

        //validating setters
        $this->assertEquals('new-base-domain', $this->sut->getBaseDomain());
        $this->assertEquals(false, $this->sut->isSecure());
        $this->assertEquals(123456, $this->sut->getTimeout());
    }

    public function testGetDomain()
    {
        $this->setProperty($this->sut,'subDomain', 'testing');
        $this->setProperty($this->sut,'baseDomain', 'example.com');

        $this->assertEquals('testing.example.com', $this->sut->getDomain());
    }

    public function testGetHost()
    {
        $this->setProperty($this->sut,'subDomain', 'subdomain');
        $this->setProperty($this->sut,'baseDomain', 'domain.lu');

        $this->assertEquals('ftp://subdomain.domain.lu', $this->sut->getHost());
    }

    public function testConstructor()
    {
        $arguments = ['subDomain', 'sitePublicKey', 'sitePrivateKey', true, 'test.com'];
        $sut       = $this->getMockForAbstractClass('Oneall\Client\AbstractClient', $arguments, '', true);

        $this->assertEquals('subDomain', $sut->getSubDomain());
        $this->assertEquals('sitePublicKey', $sut->getPublicKey());
        $this->assertEquals('sitePrivateKey', $sut->getPrivateKey());
        $this->assertEquals(true, $sut->isSecure());
        $this->assertEquals('test.com', $sut->getBaseDomain());
    }
}
