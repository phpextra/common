<?php

namespace fixtures\PHPExtra\Paginator;

use PHPExtra\Paginator\Paginator;
use PHPExtra\Type\Collection\Collection;
use PHPExtra\Type\Collection\CollectionInterface;

/**
 * The PaginatorTest class
 *
 * @author Jacek Kobus <kobus.jacek@gmail.com>
 */
class PaginatorTest extends \PHPUnit_Framework_TestCase 
{

    public function getCollection()
    {
        $collection = new Collection();
        $collection->add(1);
        $collection->add(2);
        $collection->add(3);
        $collection->add(4);
        $collection->add(5);
        $collection->add(6);

        return array(
            array(new Paginator($collection, 1, 1))
        );
    }

    public function testCreateNewPaginatorInstanceCreatesNewInstance()
    {
        new Paginator();
    }



    /**
     * @dataProvider getCollection
     */
    public function testPerformForeachLoopOnPaginator(Paginator $paginator)
    {

        /** @var Paginator|CollectionInterface[] $paginator */
        foreach($paginator as $page){
            $this->assertInstanceOf('PHPExtra\Type\Collection\CollectionInterface', $page);
            $this->assertEquals(1, $page->count());
        }

    }

    /**
     * @dataProvider getCollection
     */
    public function testAccessPaginatorLikeAnArray(Paginator $paginator)
    {
        $this->assertInstanceOf('PHPExtra\Type\Collection\CollectionInterface', $paginator[0]);
        $this->assertInstanceOf('PHPExtra\Type\Collection\CollectionInterface', $paginator[1]);
        $this->assertInstanceOf('PHPExtra\Type\Collection\CollectionInterface', $paginator[2]);
        $this->assertInstanceOf('PHPExtra\Type\Collection\CollectionInterface', $paginator[3]);
        $this->assertInstanceOf('PHPExtra\Type\Collection\CollectionInterface', $paginator[4]);
        $this->assertInstanceOf('PHPExtra\Type\Collection\CollectionInterface', $paginator[5]);

        /** @var Paginator|CollectionInterface[] $paginator */

        $this->assertEquals(1, $paginator[1]->count());

    }

    /**
     * @dataProvider getCollection
     */
    public function testChangePaginatorItemsPerPageCount(Paginator $paginator)
    {
        $paginator->setItemsPerPage(10);

        $this->assertEquals(1, $paginator->getTotalPageCount());
        $this->assertEquals(1, count($paginator));

        $this->assertEquals(6, $paginator->getPage(1)->count());
        $this->assertEquals(6, count($paginator->getPage(1)));
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testAddingAPageToPaginatorThrowsRuntimeException()
    {
        $paginator = new Paginator();
        $paginator[0] = new Collection();
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testUnsettingAPageFromPaginatorThrowsRuntimeException()
    {
        $paginator = new Paginator();
        unset($paginator[0]);
    }

    /**
     * @dataProvider getCollection
     */
    public function testToStringReturnsCurrentPageNumber(Paginator $paginator)
    {
        $this->assertEquals('1', (string)$paginator);

        $paginator->setCurrentPageNumber(5);

        $this->assertEquals('5', (string)$paginator);
    }

    /**
     * @dataProvider getCollection
     */
    public function testHasNextPageReturnsTrueIfThereIsMorePages(Paginator $paginator)
    {
        $paginator->setCurrentPageNumber(5);
        $this->assertTrue($paginator->hasNextPage());
    }

    /**
     * @dataProvider getCollection
     */
    public function testGettingNonExistingPageReturnsClosestMatchingPage(Paginator $paginator)
    {
        $collection = $paginator->getPage(20);
        $this->assertEquals(6, $collection[0]);

        $collection = $paginator->getPage(-1);
        $this->assertEquals(1, $collection[0]);
    }

    public function testGetPageOnEmptyPaginatorReturnsEmptyCollection()
    {
        $paginator = new Paginator();

        $this->assertTrue($paginator->getPage()->isEmpty());
    }


}
 