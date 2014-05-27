<?php

namespace PHPExtra\Paginator;

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
    protected $currentPage = 1;

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
     * @param int                 $itemsPerPage
     */
    function __construct(CollectionInterface $items = null, $itemsPerPage = 10)
    {
        $this->setItemsPerPage($itemsPerPage);

        if($items){
            $this->setItems($items);
        }
    }

    /**
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
        if($itemsPerPage < 1){
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
        $itemsPerPage = bcdiv($this->getItems()->count(), $this->getItemsPerPage(), 2);
        return ceil((float) $itemsPerPage);
    }

    /**
     * @return int
     */
    public function getItemsPerPage()
    {
        return $this->itemsPerPage;
    }

    /**
     * @param int $currentPage
     *
     * @return $this
     */
    public function setCurrentPage($currentPage)
    {
        $this->currentPage = $currentPage;

        return $this;
    }

    /**
     * @return CollectionInterface
     */
    public function getCurrentPage()
    {
        return $this->getPage($this->currentPage);
    }

    /**
     * @param int $number
     *
     * @return bool
     */
    public function hasPage($number)
    {
        return $this->getTotalPageCount() <= $number;
    }

    /**
     * @param int $number
     *
     * @throws \RuntimeException
     * @return CollectionInterface
     */
    public function getPage($number = 1)
    {
        $start = (($this->getItemsPerPage() * $number) - $this->getItemsPerPage());

        if($start < 0){
            $start = 0;
        }

        if ($this->getItems()->offsetExists($start)) {
            return $this->getItems()->slice($start, $this->getItemsPerPage());
        } else {
            throw new \RuntimeException(sprintf('Page out of range: %s, total: %s', $number, $this->getTotalPageCount()));
        }
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
        $this->currentPage++;
    }

    /**
     * {@inheritdoc}
     */
    public function key()
    {
        return $this->currentPage;
    }

    /**
     * {@inheritdoc}
     */
    public function valid()
    {
        return $this->hasPage($this->currentPage);
    }

    /**
     * {@inheritdoc}
     */
    public function rewind()
    {
        $this->currentPage = 1;
    }
}