<?php

namespace Oneall\Test\Api;

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
     * {@inheritdoc}
     */
    protected function setUp()
    {
        parent::setUp();
        $this->client   = $this->getMockForAbstractClass('Oneall\Client\ClientInterface');
        $this->options  = ['my' => 'option'];
        $this->response = $this->getMockForAbstractClass('Oneall\Client\Response');
    }
}
