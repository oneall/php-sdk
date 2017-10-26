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

namespace Oneall\Api\Apis;

use Oneall\Api\AbstractApi;
use Oneall\Api\Pagination;

/**
 * Class Connection
 *
 * @package Oneall\Api\Apis
 */
class Connection extends AbstractApi
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'connection';
    }

    /**
     * List all connections
     *
     * @param \Oneall\Api\Pagination|null $pagination
     *
     * @see http://docs.oneall.com/api/resources/connections/list-all-connections/
     *
     * @return \Oneall\Client\Response
     */
    public function getAll(Pagination $pagination = null)
    {
        if (!$pagination)
        {
            $pagination = new Pagination();
        }
        $response = $this->getClient()->get('/connections.json?' . $pagination->build());

        return $response;
    }

    /**
     * Read Connection Details
     *
     * @param string $token
     *
     * @see http://docs.oneall.com/api/resources/connections/read-connection-details/
     *
     * @return \Oneall\Client\Response
     */
    public function get($token)
    {
        $response = $this->getClient()->get('/connections/' . $token . '.json');

        return $response;
    }
}
