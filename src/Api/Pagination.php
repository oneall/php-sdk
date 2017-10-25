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

/**
 * Class Pagination
 *
 * Class to paginate api lists.
 *
 * @package Oneall\Api
 */
class Pagination
{
    /**
     * @var int
     */
    protected $page = 1;

    /**
     * @var int
     */
    protected $amount = 250;

    /**
     * @var
     */
    protected $order = 'asc';

    /**
     * @var int
     */
    protected $pageLabel = 'page';

    /**
     * @var int
     */
    protected $amountLabel = 'entries_per_page';

    /**
     * @var
     */
    protected $orderLabel = 'order_direction';

    /**
     * Pagination constructor.
     *
     * @param int    $page   The page to retrieve
     * @param int    $amount Number of element to retrieve
     * @param string $order  desc|asc element ordering
     */
    public function __construct($page = null, $amount = null, $order = null)
    {
        $this->setPage($page);
        $this->setAmount($amount);
        $this->setOrder($order);
    }

    /**
     * Convert object in uri query_string.
     *
     * @return string
     */
    public function build()
    {
        return http_build_query($this->asArray());
    }

    /**
     * Returns parameters as array
     *
     * @return array
     */
    public function asArray()
    {
        return [
            $this->pageLabel => $this->page,
            $this->amountLabel => $this->amount,
            $this->orderLabel => $this->order,
        ];
    }

    /**
     * @param int $pageLabel
     *
     * @return $this
     */
    public function setPageLabel($pageLabel)
    {
        $this->pageLabel = $pageLabel;

        return $this;
    }

    /**
     * @param int $amountLabel
     *
     * @return $this
     */
    public function setAmountLabel($amountLabel)
    {
        $this->amountLabel = $amountLabel;

        return $this;
    }

    /**
     * @param mixed $orderLabel
     *
     * @return $this
     */
    public function setOrderLabel($orderLabel)
    {
        $this->orderLabel = $orderLabel;

        return $this;
    }

    /**
     * @param int $page
     *
     * @return $this
     */
    public function setPage($page)
    {
        $this->page = max((int) $page, 1);

        return $this;
    }

    /**
     * @param int $amount
     *
     * @return $this
     */
    public function setAmount($amount)
    {
        $amount = (int) $amount;

        if ($amount < 1 || $amount > 500)
        {
            $amount = 250;
        }

        $this->amount = $amount;

        return $this;
    }

    /**
     * @param string $order asc|desc
     *
     * @return $this
     */
    public function setOrder($order)
    {
        if ($order != 'desc')
        {
            $order = 'asc';
        }
        $this->order = $order;

        return $this;
    }
}
