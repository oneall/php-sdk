<?php

namespace Oneall\Test\Api;

use Oneall\Api\Pagination;
use Oneall\Test\PhpUnitHelperTrait;

class PaginationTest extends \PHPUnit_Framework_TestCase
{
    use PhpUnitHelperTrait;

    /**
     * @var \Oneall\Api\Pagination
     */
    protected $sut;

    protected function setUp()
    {
        $this->sut = new Pagination();
    }

    public function testConstructor()
    {
        $this->assertEquals(1, $this->getProperty($this->sut, 'page'));
        $this->assertEquals(250, $this->getProperty($this->sut, 'amount'));
        $this->assertEquals('asc', $this->getProperty($this->sut, 'order'));

        $this->assertEquals('page', $this->getProperty($this->sut, 'pageLabel'));
        $this->assertEquals('entries_per_page', $this->getProperty($this->sut, 'amountLabel'));
        $this->assertEquals('order_direction', $this->getProperty($this->sut, 'orderLabel'));
    }

    /**
     * @depends testConstructor
     */
    public function testSetGetPageLabel()
    {
        $this->assertSame($this->sut, $this->sut->setPageLabel('newvalue'));
        $this->assertEquals('newvalue', $this->getProperty($this->sut, 'pageLabel'));
    }

    /**
     * @depends testConstructor
     */
    public function testSetGetAmountLabel()
    {
        $this->assertSame($this->sut, $this->sut->setAmountLabel('newvalue'));
        $this->assertEquals('newvalue', $this->getProperty($this->sut, 'amountLabel'));
    }

    /**
     * @depends testConstructor
     */
    public function testSetGetOrderLabel()
    {
        $this->assertSame($this->sut, $this->sut->setOrderLabel('newvalue'));
        $this->assertEquals('newvalue', $this->getProperty($this->sut, 'orderLabel'));
    }

    /**
     * @dataProvider provideTestSetAmount
     *
     * @param $value
     * @param $expected
     */
    public function testSetAmount($value, $expected)
    {
        $this->assertSame($this->sut, $this->sut->setAmount($value));
        $this->assertEquals($expected, $this->getProperty($this->sut, 'amount'));
    }

    /**
     * @return array
     */
    public function provideTestSetAmount()
    {
        return [
            [-1, 250],
            [0, 250],
            [10, 10],
            [500, 500],
            [501, 250],
        ];
    }

    /**
     * @dataProvider provideTestSetPage
     *
     * @param $value
     * @param $expected
     */
    public function testSetPage($value, $expected)
    {
        $this->assertSame($this->sut, $this->sut->setPage($value));
        $this->assertEquals($expected, $this->getProperty($this->sut, 'page'));
    }

    /**
     * @return array
     */
    public function provideTestSetPage()
    {
        return [
            [-1, 1],
            [1, 1],
            [10, 10],
            [500, 500],
            ['abc', 1],
        ];
    }

    /**
     * @dataProvider provideTestSetOrder
     *
     * @param $value
     * @param $expected
     */
    public function testSetOrder($value, $expected)
    {
        $this->assertSame($this->sut, $this->sut->setOrder($value));
        $this->assertEquals($expected, $this->getProperty($this->sut, 'order'));
    }

    /**
     * @return array
     */
    public function provideTestSetOrder()
    {
        return [
            ['asc', 'asc'],
            ['desc', 'desc'],
            [null, 'asc'],
            [0, 'asc'],
            ['something', 'asc'],
        ];
    }

    /**
     * @depends testConstructor
     */
    public function testAsArray()
    {
        $expected = [
            'page' => 1,
            'entries_per_page' => 250,
            'order_direction' => 'asc',
        ];

        $this->assertEquals($expected, $this->sut->asArray());
    }

    /**
     * @depends testConstructor
     * @depends testSetAmount
     * @depends testSetPage
     * @depends testSetOrder
     */
    public function testAsArraywithCustomValue()
    {
        $this->sut->setPage(40);
        $this->sut->setAmount(20);
        $this->sut->setOrder('desc');

        $expected = [
            'page' => 40,
            'entries_per_page' => 20,
            'order_direction' => 'desc',
        ];

        $this->assertEquals($expected, $this->sut->asArray());
    }

    /**
     * @depends testConstructor
     */
    public function testBuild()
    {
        $expected = 'page=1&entries_per_page=250&order_direction=asc';

        $this->assertEquals($expected, $this->sut->build());
    }

    /**
     * @depends testConstructor
     * @depends testSetAmount
     * @depends testSetPage
     * @depends testSetOrder
     */
    public function testBuildWithCustomValues()
    {
        $this->sut->setPage(40);
        $this->sut->setAmount(20);
        $this->sut->setOrder('desc');

        $expected = 'page=40&entries_per_page=20&order_direction=desc';

        $this->assertEquals($expected, $this->sut->build());
    }
}
