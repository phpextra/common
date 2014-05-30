<?php

namespace PHPExtra\Paginator;

use PHPExtra\Type\Collection\Collection;
use PHPExtra\Type\Collection\CollectionInterface;

/**
 * The Paginator class
 *
 * @author Jacek Kobus <kobus.jacek@gmail.com>
 */
class Paginator implements \Iterator, \Countable, \ArrayAccess
{
    /**
     * @var int
     */
    protected $currentPageNumber = 1;

    /**
     * @var int
     */
    protected $itemsPerPage = 10;

    /**
     * @var
     */
    protected $items;

    /**
     * @param CollectionInterface $items
     * @param int                 $currentPageNumber
     * @param int                 $itemsPerPage
     */
    function __construct(CollectionInterface $items = null, $currentPageNumber = 1, $itemsPerPage = 10)
    {
        $this->setItemsPerPage($itemsPerPage);

        if ($items) {
            $this->setItems($items);
        }

        $this->setCurrentPageNumber($currentPageNumber);
    }

    /**
     * Set collection that will be split into pages
     *
     * @param CollectionInterface $items
     *
     * @return $this
     */
    public function setItems(CollectionInterface $items)
    {
        $this->items = $items;

        return $this;
    }

    /**
     * Get all items from paginator
     *
     * @return CollectionInterface
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param int $itemsPerPage
     *
     * @throws \RuntimeException
     * @return $this
     */
    public function setItemsPerPage($itemsPerPage)
    {
        if ($itemsPerPage < 1) {
            throw new \RuntimeException('Items per page must be > 0');
        }
        $this->itemsPerPage = $itemsPerPage;

        return $this;
    }

    /**
     * @return int
     */
    public function getTotalPageCount()
    {
        $itemsPerPage = bcdiv(count($this->getItems()), $this->getItemsPerPage(), 2);

        return ceil((float)$itemsPerPage);
    }

    /**
     * @return int
     */
    public function getItemsPerPage()
    {
        return $this->itemsPerPage;
    }

    /**
     * @param int $number
     *
     * @return bool
     */
    public function hasPage($number)
    {
        return $this->getTotalPageCount() >= $number;
    }

    /**
     * Set current page number
     *
     * @param int $currentPageNumber
     *
     * @return $this
     */
    public function setCurrentPageNumber($currentPageNumber)
    {
        $this->currentPageNumber = $currentPageNumber;

        return $this;
    }

    /**
     * Get current page number
     *
     * @return int
     */
    public function getCurrentPageNumber()
    {
        return $this->currentPageNumber;
    }

    /**
     * Return given page number (or current), if page number is null
     * If page does not exists paginator will get the closest matching page or an empty
     * collection if there is no pages
     * To see if page actually exists, use hasPage() method
     *
     * @param int $number
     *
     * @throws \RuntimeException
     * @return CollectionInterface
     */
    public function getPage($number = null)
    {
        if ($number === null) {
            $number = $this->getCurrentPageNumber();
        }

        if($number > $this->getLastPageNumber()){
            $number = $this->getLastPageNumber();
        }

        if($number < 1){
            $number = 1;
        }

        $start = (($this->getItemsPerPage() * $number) - $this->getItemsPerPage());

        if ($start < 0) {
            $start = 0;
        }

        if ($this->getItems() !== null && $this->getItems()->offsetExists($start)) {
            return $this->getItems()->slice($start, $this->getItemsPerPage());
        } else {
            return new Collection();
        }
    }

    /**
     * @return CollectionInterface
     */
    public function getCurrentPage()
    {
        return $this->getPage();
    }

    /**
     * @return bool
     */
    public function hasPreviousPage()
    {
        return $this->hasPage($this->getCurrentPageNumber() - 1);
    }

    /**
     * @return CollectionInterface
     */
    public function getPreviousPage()
    {
        return $this->getPage($this->getCurrentPageNumber() - 1);
    }

    /**
     * @return int
     */
    public function getPreviousPageNumber()
    {
        return $this->getCurrentPageNumber() - 1;
    }

    /**
     * @return bool
     */
    public function hasNextPage()
    {
        return $this->hasPage($this->getNextPageNumber());
    }

    /**
     * @return int
     */
    public function getNextPageNumber()
    {
        return $this->getCurrentPageNumber() + 1;
    }

    /**
     * @return CollectionInterface
     */
    public function getNextPage()
    {
        return $this->getPage($this->getNextPageNumber());
    }

    /**
     * @return CollectionInterface
     */
    public function getLastPage()
    {
        return $this->getPage($this->getLastPageNumber());
    }

    /**
     * @return int
     */
    public function getLastPageNumber()
    {
        return $this->getTotalPageCount();
    }

    /**
     * {@inheritdoc}
     */
    public function offsetExists($offset)
    {
        return $this->hasPage($offset);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetGet($offset)
    {
        return $this->getPage($offset + 1);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet($offset, $value)
    {
        throw new \RuntimeException('Cannot add a page to paginator');
    }

    /**
     * {@inheritdoc}
     */
    public function offsetUnset($offset)
    {
        throw new \RuntimeException('Cannot remove a page from paginator');
    }

    /**
     * Get total page count
     *
     * @return int
     */
    public function count()
    {
        return $this->getTotalPageCount();
    }

    /**
     * {@inheritdoc}
     */
    public function current()
    {
        return $this->getCurrentPage();
    }

    /**
     * {@inheritdoc}
     */
    public function next()
    {
        $this->currentPageNumber++;
    }

    /**
     * {@inheritdoc}
     */
    public function key()
    {
        return $this->currentPageNumber;
    }

    /**
     * {@inheritdoc}
     */
    public function valid()
    {
        return $this->hasPage($this->currentPageNumber);
    }

    /**
     * {@inheritdoc}
     */
    public function rewind()
    {
        $this->currentPageNumber = 1;
    }

    /**
     * Returns current page number
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getCurrentPageNumber();
    }
}