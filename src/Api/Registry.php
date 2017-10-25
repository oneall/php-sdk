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

use Oneall\Exception\ApiNotFound;

/**
 * Class Registry
 *
 * @package Oneall\Api
 */
class Registry
{
    /**
     * @var AbstractApi[]
     */
    protected $apis = [];

    /**
     * Add (or replace) a api
     *
     * @param \Oneall\Api\AbstractApi $api
     *
     * @return $this
     */
    public function add(AbstractApi $api)
    {
        $this->apis[$api->getName()] = $api;

        return $this;
    }

    /**
     * Returns whether the api exists
     *
     * @param string $name
     *
     * @return bool
     */
    public function has($name)
    {
        if (empty($this->apis[$name]))
        {
            return false;
        }

        return ($this->apis[$name]) instanceof AbstractApi;
    }

    /**
     * @param $name
     *
     * @return AbstractApi
     */
    public function get($name)
    {
        if (!$this->has($name))
        {
            throw new ApiNotFound($name);
        }

        return $this->apis[$name];
    }
}
