<?php

namespace Oneall\Test\Api;

use Oneall\Api\Pagination;

class TestingApi extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Oneall\Client\ClientInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $client;

    /**
     * Our testing timeout
     *
     * @var int
     */
    protected $timeout = 60;

    /**
     * Our testing options
     *
     * @var array
     */
    protected $options;

    /**
     * Our testing response
     *
     * @var \StdClass
     */
    protected $response;

    /**
     * Our testing response
     *
     * @var \Oneall\Api\Pagination|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $pagination;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        parent::setUp();
        $this->client   = $this->getMockForAbstractClass('Oneall\Client\ClientInterface');
        $this->options  = ['my' => 'option'];
        $this->response = $this->getMockForAbstractClass('Oneall\Client\Response');

        $this->pagination = $this->getMockForAbstractClass('Oneall\Api\Pagination');
        $this->pagination->method('build')->willReturn('?page=10&entries_per_page=10&order_direction=desc');
    }

    /**
     * @return string
     */
    protected function getDefaultPaginationQuery()
    {
        $pagination = new Pagination();

        return $pagination->build();
    }

    /**
     * @param int    $page
     * @param int    $amount
     * @param string $order
     *
     * @return string
     */
    protected function getCustomPaginationBuild($page, $amount, $order)
    {
        $pagination = new Pagination($page, $amount, $order);

        return $pagination->build();
    }
}
