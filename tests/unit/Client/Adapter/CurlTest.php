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

namespace Oneall\Test\Client\Adapter;

use Oneall\Client\Adapter\Curl;
use Oneall\Test\PhpUnitHelperTrait;

/**
 * Class CurlTest
 *
 * @package Oneall\Test\Client\Adapter
 */
class CurlTest extends \PHPUnit_Framework_TestCase
{
    use PhpUnitHelperTrait;

    /**
     * @var \Oneall\Client\Adapter\Curl
     */
    protected $sut;

    protected function setUp()
    {
        parent::setUp();
        $this->sut = new Curl('my-subDomain', 'my-sitePublicKey', 'my-sitePrivateKey', ['options']);
    }

    public function testGetName()
    {
        $this->assertEquals('curl', $this->sut->getName());
    }

    public function testGetScheme()
    {
        $this->setProperty($this->sut, 'isSecure', true);
        $this->assertEquals('https', $this->sut->getScheme());

        $this->setProperty($this->sut, 'isSecure', false);
        $this->assertEquals('http', $this->sut->getScheme());
    }

}
