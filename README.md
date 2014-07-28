#Common classes and interfaces for PHP
[![Latest Stable Version](https://poser.pugx.org/phpextra/sorter/v/stable.svg)](https://packagist.org/packages/phpextra/common)
[![Total Downloads](https://poser.pugx.org/phpextra/common/downloads.svg)](https://packagist.org/packages/phpextra/common)
[![License](https://poser.pugx.org/phpextra/common/license.svg)](https://packagist.org/packages/phpextra/common)
[![Build Status](http://img.shields.io/travis/phpextra/common.svg)](https://travis-ci.org/phpextra/common)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/phpextra/common/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/phpextra/common/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/phpextra/common/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/phpextra/common/?branch=master)
[![GitTip](http://img.shields.io/gittip/jkobus.svg)](https://www.gittip.com/jkobus)

##Usage

###Enum (PHPExtra\Type\Enum)

Create your first enum type by creating a new class:

```php
class TheGuy extends AbstractEnum
{
    const _default = self::NICE_GUY;
    const SMART_GUY = 'Mike';
    const NICE_GUY = 'Rick';
}
```

Thats all.

Now you can use it:

```php
$guy = new TheGuy();
echo $guy->getValue(); // returns Rick

$mike = new TheGuy(TheGuy::MIKE);
echo $mike->getValue(); // returns Mike

echo $guy->equals($mike); // returns false
```

If no default value will be specified, you must set it as a constructor argument.
If given constructor value will be invalid, ``\UnexpectedValueException`` will be thrown.

###Collection (PHPExtra\Type\Collection)

Collections solve few things by implementing following interfaces: ``\Countable``, ``\ArrayAccess``, ``\Iterator``, and ``\SortableInterface``.
This gives you an ability to ``count()`` collection, use a ``foreach`` on it, access it like an array ``$a[1]`` and sort its contents ``$a->sort($sorter)``.
Apart from regular collections there are also ``LazyCollection``'s that allow you to specify a closure that will initialize collection
contents only if and when it's needed.

Create your first collection:

```php
$collection = new Collection();

$collection->add('item1');
$collection->add('item2');
$collection->add('item3);
```

Use it:

```php
echo count($collection); // returns 3
echo $collection[0]; // returns "item1"
echo $collection->slice(1, 2); // returns Collection with a length of 2 containing item2 and item3.
echo $collection->filter(function($element, $offset){ return $offset % 2 == 0; }); // returns sub-collection with all elements with even offset number
$collection->sort(SorterInterface $sorter); // sorts collection
```

Lazy collection example:

```php
$lazy = new LazyCollection(function(){
    return new Collection(array(1, 2, 3));
});

echo $lazy[2]; // initializes the closure and returns "3"
```

###UnknownType (PHPExtra\Type\UnknownType)

It should not happen but sometimes does - you have a method with many different response types, but want to handle it like a pro:

```php
$messedUpResponse = $api->getMeSomeChickens(); // returns "Chicken" **or** "Collection" **of** "Chickens" **or** "no" as an error response :-)

$result = new UnknownType($messedUpResponse);

if($result->isCollection()){
    $result->getAsCollection()->sort($sorter);
    ...
}elseif($result->isException){
    throw $result->getAsException();
    ...
}
```

UnknownType can be extended and customized :-)

###Paginator (PHPExtra\Paginator)

Paginator is fully compatible with CollectionInterface. It's task is to split large collections into pages.

```php
$page = 2;
$itemsPerPage = 10;
$products = new Collection(...);
$paginator = new Paginator($products, $page, $itemsPerPage);

echo $paginator->getPage(); // returns a collection with size of 10 for current page
echo $paginator->getNextPageNumber(); // returns "3"
echo $paginator->hasNextPage(); // returns bool true or false
```

##Changelog

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

## Installation (Composer)

```json
{
    "require": {
        "phpextra/common":"~1.2"
    }
}
```

##Running tests

```
// Windows
composer install & call ./vendor/bin/phpunit.bat ./tests
```

##Contributing

All code contributions must go through a pull request.
Fork the project, create a feature branch, and send me a pull request.
To ensure a consistent code base, you should make sure the code follows
the [coding standards](http://symfony.com/doc/2.0/contributing/code/standards.html).
If you would like to help take a look at the [list of issues](https://github.com/phpextra/common/issues).

##Requirements

See **composer.json** for a full list of dependencies.

##Authors

Jacek Kobus - <kobus.jacek@gmail.com>

## License information

    See the file LICENSE.txt for copying permission.


