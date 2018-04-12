<?php

use Sami\Parser\Filter\TrueFilter;
use Sami\RemoteRepository\GitHubRemoteRepository;
use Sami\Sami;
use Symfony\Component\Finder\Finder;

$iterator = Finder::create()
    ->files()
    ->name("*.php")
    ->exclude("tests")
    ->in($dir = "src");

$versions = \Sami\Version\GitVersionCollection::create($dir)
    ->addFromTags("v1.0.*")
    ->add("master", "Development master");

$sami = new Sami($iterator, array(
    "title" => "NormForm API",
    "versions" => $versions,
    "build_dir" => __DIR__ . "/docs/%version%",
    "cache_dir" => __DIR__ . "/cache/%version%",
    "remote_repository" => new GitHubRemoteRepository("Digital-Media/normform", __DIR__),
    "default_opened_level" => 2
));

// Also include private properties and methods
$sami["filter"] = function () {
    return new TrueFilter();
};

return $sami;
