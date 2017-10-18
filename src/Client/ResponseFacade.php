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

namespace Oneall\Client;

/**
 * Class ResponseFacade
 *
 * @package Oneall\Client
 */
class ResponseFacade
{
    /**
     * @var object
     */
    protected $body;

    /**
     * ResponseFacade constructor.
     *
     * @param object $body
     */
    public function __construct($body)
    {
        $this->body = $body;
    }

    /**
     * Merge value in array following the given path
     *
     * @param string $path path in array , separated with /
     *²
     * @return mixed
     */
    protected function getObjectValue($path)
    {
        $parts = array_filter(explode('/', $path), function ($value) {
            return strlen((string) $value) > 0;
        });

        $pointer = $this->body;

        try
        {
            foreach ($parts as $part)
            {
                if (is_array($pointer))
                {
                    if (!array_key_exists($part, $pointer))
                    {
                        return null;
                    }

                    $pointer = $pointer[$part];
                    continue;
                }

                // on object case
                if (!property_exists($pointer, $part))
                {
                    return null;
                }

                $pointer = $pointer->$part;
            }
        }
        catch (\Exception $exception)
        {
            return null;
        }

        return $pointer;
    }
}
