<?php

use Sami\Sami;
use Sami\Version\GitVersionCollection;
use Symfony\Component\Finder\Finder;

$src = __DIR__ .'/../src';
$iterator = Finder::create()
    ->files()
    ->name('*.php')
    ->in($src)
;

$versions = GitVersionCollection::create($src . '/../')
    ->addFromTags()
    ->add('master', 'master')
;

return new Sami($iterator, array(
    'theme'                => 'enhanced',
    'versions'             => $versions,
    'title'                => 'Project API',
    'build_dir'            => __DIR__.'/api/%version%',
    'cache_dir'            => __DIR__.'/api/%version%',
    'default_opened_level' => 2,
));