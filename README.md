#Common classes and interfaces for PHP

##Changelog

###1.2.0

- added sorter support - sort(SorterInterface $sorter)

###1.1.1

- Collection::current() now returns null on empty collection

###1.1.0

- added PaginatorInterface
- added default, optional, value holders for page number getters
- added forAll(Closure $c) method in Collection

###1.0.3 (cannot be downgraded)

- changed paginator behaviour - wil lreturn closest matching page ig page number is out of range or empty collection
- added getters for last page and its number

###1.0.2 (cannot be downgraded)

- fixed paginator page hasser that returned false positives
- fixed slice() to not use array_slice on Collections
- paginator changes; added hassers and getters for pages, toString method (returns current page number), changed constructor

###1.0.1 (cannot be downgraded)

- added paginator that can handle large collections and split them between pages of given length
- reset internal pointer after filter() in collections
- added first() and last() method in collections
- fixed exception message in UnknownType for getAsCollection() method

###1.0.0

First release

##Contributing

All code contributions must go through a pull request.
Fork the project, create a feature branch, and send me a pull request.
To ensure a consistent code base, you should make sure the code follows
the [coding standards](http://symfony.com/doc/2.0/contributing/code/standards.html).
If you would like to help take a look at the **list of issues**.

##Requirements

See **composer.json** for a full list of dependencies.

##Authors

Jacek Kobus - <kobus.jacek@gmail.com>

## License information

    See the file LICENSE.txt for copying permission.