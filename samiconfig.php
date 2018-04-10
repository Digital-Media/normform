<?php

use Sami\Parser\Filter\TrueFilter;
use Sami\Sami;
use Symfony\Component\Finder\Finder;

$iterator = Finder::create()
    ->files()
    ->name('*.php')
    ->exclude('tests')
    ->in('src');

$sami = new Sami($iterator, array(
    'title' => 'NormForm API',
    'build_dir' => __DIR__ . '/docs/',
    'cache_dir' => __DIR__ . '/cache/',
));

// Also include private properties and methods
$sami["filter"] = function () {
    return new TrueFilter();
};

return $sami;
