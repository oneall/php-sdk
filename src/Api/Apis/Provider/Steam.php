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

namespace Oneall\Api\Apis\Provider;

use Oneall\Api\AbstractApi;

/**
 * Class Steam
 *
 * This provider is used for all interaction with Steam provider
 *
 * @package Oneall\Api\Apis\Provider
 */
class Steam extends AbstractApi
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'steam';
    }

    /**
     * Steam \ List Games
     *
     * @param string $identityToken
     * @param int $num_games
     * @param int $page
     * @param string $only_game_id
     *
     *
     * @see http://docs.oneall.com/api/resources/identities/steam/list-games/
     *
     * @return \Oneall\Client\Response
     */
    public function pullGames($identityToken, $num_games = 50, $page = '', $only_game_id = '')
    {
        $data = '?num_games=' . $num_games;
        $data .= !empty($page) && is_int($page) ? '&page=' . $page : '';
        $data .= !empty($only_game_id) ? '&only_game_id=' . $only_game_id : '';

        return $this->getClient()->get('/pull/identities/' . $identityToken . '/steam/games.json' . $data);
    }
}
