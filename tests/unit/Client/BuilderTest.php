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

use Oneall\Client\Builder;

/**
 * Class BuilderTest
 *
 * @package Oneall\Test\Client
 */
class BuilderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Oneall\Client\Builder
     */
    protected $sut;

    /**
     * @var
     */
    protected $subDomain = 'subdomain';
    /**
     * @var
     */
    protected $publicKey = 'pub-key';
    /**
     * @var
     */
    protected $privateKey = 'priv-key';
    /**
     * @var bool
     */
    protected $isSecure = true;

    /**
     * @var string
     */
    protected $base = 'example.com';

    protected function setUp()
    {
        parent::setUp();

        $this->sut = new Builder();
    }

    public function testBuildCurlHandler()
    {
        $curl = $this->sut->build('curl', 'subDomain', 'publicKey', 'privateKey', true, 'example.base.com');
        $this->assertInstanceOf('Oneall\Client\Adapter\Curl', $curl);
    }

    public function testBuildFSOckOpenHandler()
    {
        $fsockopen = $this->sut->build('fsockopen', 'subDomain', 'publicKey', 'privateKey', true, 'example.base.com');
        $this->assertInstanceOf('Oneall\Client\Adapter\FSockOpen', $fsockopen);
    }

    public function testBuildException()
    {
        $this->setExpectedException('\RuntimeException');
        $this->sut->build('somethingwrong', 'a', 'b', 'c', true, 'd');
    }
}
