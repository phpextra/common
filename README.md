#Common classes and interfaces for PHP

[![Latest Stable Version](https://poser.pugx.org/phpextra/collection/v/stable.svg)](https://packagist.org/packages/phpextra/collection)
[![Total Downloads](https://poser.pugx.org/phpextra/collection/downloads.svg)](https://packagist.org/packages/phpextra/collection)
[![License](https://poser.pugx.org/phpextra/collection/license.svg)](https://packagist.org/packages/phpextra/collection)
[![Build Status](http://img.shields.io/travis/phpextra/collection.svg)](https://travis-ci.org/phpextra/collection)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/phpextra/collection/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/phpextra/collection/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/phpextra/collection/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/phpextra/collection/?branch=master)
[![GitTip](http://img.shields.io/gittip/jkobus.svg)](https://www.gittip.com/jkobus)

##Changelog

###2.0.x

    - Common is now a metapackage.

###1.2.x

    - removed Serializable interface from Collection
    - added Serializable interface to LazyCollection
    - added deprecation mark to LazyCollection which **will became** **final** in 1.3
    - added **CollectionProxy** class
    - added CollectionInterface::sort(SorterInterface $sorter) for collections
    - added EnumInterface::equals(EnumInterface $enum) for enums
    - added UnknownType::isSortable() for unknown type
    - re-worked Enum type:
        - added deprecation mark to **Enum class** as it will be changed to **abstract** in 1.3
        - added default value for enums
        - AbstractEnum::isValid($val) is now static
        - added AbstractEnum:isEqual(EnumInterface $enum)
    - updated README

###1.1.1

    - Collection::current() now returns null on empty collection

###1.1.0

    - added PaginatorInterface
    - added default, optional, value holders for page number getters
    - added Collection::forAll(Closure $c) method in collections

###1.0.3 (cannot be downgraded)

    - changed paginator behaviour - will return closest matching page ig page number is out of range or empty collection
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

    See composer.json for a full list of dependencies.

##Authors

    Jacek Kobus - <kobus.jacek@gmail.com>

## License information

    See the file LICENSE.txt for copying permission.