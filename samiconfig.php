<?php

use Sami\Sami;
use Symfony\Component\Finder\Finder;

$iterator = Finder::create()
    ->files()
    ->name('*.php')
    ->exclude('tests')
    ->in('src')
;

return new Sami($iterator, array(
    'title'                => 'NormForm API',
    'build_dir'            => __DIR__.'/docs/',
    'cache_dir'            => __DIR__.'/cache/',
));
