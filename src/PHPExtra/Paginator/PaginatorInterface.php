<?php

namespace PHPExtra\Paginator;
use PHPExtra\Type\Collection\CollectionInterface;

/**
 * The PaginatorInterface interface
 * Paginator always have a first page even when its empty
 *
 * @author Jacek Kobus <kobus.jacek@gmail.com>
 */
interface PaginatorInterface extends \Iterator, \Countable, \ArrayAccess
{
    /**
     * Get all items from paginator
     *
     * @return CollectionInterface
     */
    public function getItems();

    /**
     * @return CollectionInterface
     */
    public function getCurrentPage();

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
    public function getPage($number = null);

    /**
     * @param int $number
     *
     * @return bool
     */
    public function hasPage($number);

    /**
     * Set current page number
     *
     * @param int $currentPageNumber
     *
     * @return $this
     */
    public function setCurrentPageNumber($currentPageNumber);

    /**
     * @return int
     */
    public function getTotalPageCount();

    /**
     * Set collection that will be split into pages
     *
     * @param CollectionInterface $items
     *
     * @return $this
     */
    public function setItems(CollectionInterface $items);

    /**
     * Set item count per page
     *
     * @param int $itemsPerPage
     *
     * @throws \RuntimeException
     * @return $this
     */
    public function setItemsPerPage($itemsPerPage);

    /**
     * Get items count per page
     * @return int
     */
    public function getItemsPerPage();

    /**
     * @return bool
     */
    public function hasPreviousPage();

    /**
     * @return CollectionInterface
     */
    public function getNextPage();

    /**
     * @return bool
     */
    public function hasNextPage();

    /**
     * Get current page number
     *
     * @return int
     */
    public function getCurrentPageNumber();

    /**
     * @param mixed $default
     *
     * @return int
     */
    public function getNextPageNumber($default = null);

    /**
     * @param mixed $default
     *
     * @return int
     */
    public function getPreviousPageNumber($default = null);

    /**
     * @return CollectionInterface
     */
    public function getPreviousPage();

    /**
     * @return int
     */
    public function getLastPageNumber();

    /**
     * @return CollectionInterface
     */
    public function getLastPage();

    /**
     * Returns current page number
     *
     * @return string
     */
    public function __toString();
}