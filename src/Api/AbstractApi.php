<?php

/**
 * @package      Oneall PHP SDK
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

use Oneall\Client\ClientInterface;

/**
 * Class AbstractApi
 *
 * @package Oneall\Api
 */
abstract class AbstractApi
{
    /**
     * Default timeout client
     */
    CONST DEFAULT_TIMEOUT = 30;

    /**
     * @var \Oneall\Client\ClientInterface
     */
    protected $client;

    /**
     * @var int
     */
    protected $timeout;

    /**
     * AbstractApi constructor.
     *
     * @param ClientInterface $client
     * @param int             $timeout
     */
    public function __construct(ClientInterface $client, $timeout = self::DEFAULT_TIMEOUT)
    {
        $this->client  = $client;
        $this->timeout = $timeout;
    }

    /**
     * Returns api's name
     *
     * @return string
     */
    abstract public function getName();

    /**
     * @return \Oneall\Client\ClientInterface
     */
    protected function getClient()
    {
        return $this->client;
    }

    /**
     * @return int
     */
    protected function getTimeout()
    {
        return $this->timeout;
    }

    /**
     * Merge value in array following the given path
     *
     * While our request json structure can be quite complex, this method is used to ease conditional data injection in
     * deep array
     *
     * @param array  $array
     * @param string $path path in array , separated with /
     * @param mixed  $value
     *
     * @example $api->addInfo($exampleArray, 'long/path/to/the/element/to/set/in/array', $theValueToSet );
     *
     * @return array the modified array
     */
    protected function addInfo(array $array, $path, $value)
    {
        if ($value === null || (is_array($value) && empty($value)))
        {
            return $array;
        }

        $parts = array_filter(explode('/', $path));

        $pointer = &$array;
        foreach ($parts as $part)
        {
            if (!is_array($pointer) || !array_key_exists($part, $pointer))
            {
                $pointer[$part] = null;
            }

            $pointer = &$pointer[$part];
        }
        $pointer = $value;

        return $array;
    }
}
