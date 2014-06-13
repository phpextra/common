<?php

namespace PHPExtra\Paginator;

use PHPExtra\Type\Collection\Collection;
use PHPExtra\Type\Collection\CollectionInterface;

/**
 * The Paginator class
 *
 * @author Jacek Kobus <kobus.jacek@gmail.com>
 */
class Paginator implements PaginatorInterface
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
     * {@inheritdoc}
     */
    public function setItems(CollectionInterface $items)
    {
        $this->items = $items;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * {@inheritdoc}
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
     * {@inheritdoc}
     */
    public function getTotalPageCount()
    {
        $itemsPerPage = bcdiv(count($this->getItems()), $this->getItemsPerPage(), 2);

        return ceil((float)$itemsPerPage);
    }

    /**
     * {@inheritdoc}
     */
    public function getItemsPerPage()
    {
        return $this->itemsPerPage;
    }

    /**
     * {@inheritdoc}
     */
    public function hasPage($number)
    {
        return ($number > 0 && $this->getTotalPageCount() >= $number) || $number == 1;
    }

    /**
     * {@inheritdoc}
     */
    public function setCurrentPageNumber($currentPageNumber)
    {
        $this->currentPageNumber = $currentPageNumber;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCurrentPageNumber()
    {
        return $this->currentPageNumber;
    }

    /**
     * {@inheritdoc}
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
     * {@inheritdoc}
     */
    public function getCurrentPage()
    {
        return $this->getPage();
    }

    /**
     * {@inheritdoc}
     */
    public function hasPreviousPage()
    {
        return $this->getPreviousPageNumber() !== null;
    }

    /**
     * {@inheritdoc}
     */
    public function getPreviousPage()
    {
        return $this->getPage($this->getPreviousPageNumber());
    }

    /**
     * {@inheritdoc}
     */
    public function getPreviousPageNumber($default = null)
    {
        $previous = $this->getCurrentPageNumber() - 1;
        return $this->hasPage($previous) ? $previous : $default;
    }

    /**
     * {@inheritdoc}
     */
    public function hasNextPage()
    {
        return $this->getNextPageNumber() !== null;
    }

    /**
     * {@inheritdoc}
     */
    public function getNextPageNumber($default = null)
    {
        $next = $this->getCurrentPageNumber() + 1;
        return $this->hasPage($next) ? $next : $default;
    }

    /**
     * {@inheritdoc}
     */
    public function getNextPage()
    {
        return $this->getPage($this->getNextPageNumber());
    }

    /**
     * {@inheritdoc}
     */
    public function getLastPage()
    {
        return $this->getPage($this->getLastPageNumber());
    }

    /**
     * {@inheritdoc}
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
     * {@inheritdoc}
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
     * {@inheritdoc}
     */
    public function __toString()
    {
        return (string) $this->getCurrentPageNumber();
    }
}