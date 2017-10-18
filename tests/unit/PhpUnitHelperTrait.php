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

/**
 * Trait PhpUnitHelperTrait
 *
 * @package Oneall\Test
 */
trait PhpUnitHelperTrait
{
    /**
     * Set protected property value on an object
     *
     * @param object $object
     * @param string $property
     * @param mixed  $value
     *
     * @return $this
     */
    public function setProperty($object, $property, $value)
    {
        $property = new \ReflectionProperty($object, $property);
        $property->setAccessible(true);
        $property->setValue($object, $value);

        return $this;
    }

    /**
     * Retuns protected object property value
     *
     * @param object $object
     * @param string $property
     *
     * @return mixed
     */
    public function getProperty($object, $property)
    {
        $property = new \ReflectionProperty($object, $property);
        $property->setAccessible(true);

        return $property->getValue($object);
    }

    /**
     * Invoke a protected method on an object & returns its result.
     *
     * @param object $object
     * @param string $method
     * @param array  $arguments
     *
     * @return mixed
     */
    public function invoke($object, $method, array $arguments = [])
    {
        $reflected = new \ReflectionMethod($object, $method);
        $reflected->setAccessible(true);

        return $reflected->invokeArgs($object, $arguments);
    }
}
