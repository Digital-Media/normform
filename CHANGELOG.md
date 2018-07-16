# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [1.1.0] - 2018-05-14
### Added
- `$_SESSION` is passed to the template engine as `_session`.

### Removed
- PHPUnit dev-dependency (only necessary for normform-skeleton)

### Fixed
- Simplified normForm() method to remove redundancies: [11: Update AbstractNormForm.php](https://github.com/Digital-Media/normform/pull/11).
- Updated .gitignore to make exclusion of directories more strict and only exclude on root level.

## [1.0.0] - 2018-04-11
### Added
- Project now follows [Semantic Versioning](http://semver.org/spec/v2.0.0.html). Old version (2017) will not be part of the versioning structure, but will live on in Git history.
- New directory structure (src, docs), ready for [Composer](https://getcomposer.org/).
- composer.json and composer.lock to declare project information and dependencies.
- PHP version 7.1 requirement.
- [Twig template engine](https://github.com/twigphp/Twig) for rendering and displaying output
- Namespaces "Fhooe/Core", "Fhooe/Parameter" and "Fhooe/View".
- API Documentation generated using [Sami](https://github.com/FriendsOfPHP/Sami). 
- Changelog (yes, this one) based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/).
