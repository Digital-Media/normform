# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [1.2.3] - 2021-02-08

### Fixed
- Changed PHP version constraint to >=7.1 to support PHP 8.0.

## [1.2.2] - 2020-03-22
### Changed
- Updated dependencies to Twig ^3.0. This is a non-breaking, backwards-compatible change.
- Made code fully PSR-12 compliant.

### Fixed
- Removed some unreachable code blocks.

## [1.2.1] - 2018-10-12
### Fixed
- Forced LF line breaks on checkout to avoid unpredictable behavior.

## [1.2.0] - 2018-07-16
### Added
- It is now possible to use normform with AJAX requests. show() is not called if currentView is an invalid View object.
- The template is not displayed in this case. The HTTP response can be sent with echo.

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

## [0.1.0] - 2017-09-20
### Added
- Added the original 2017 NormForm for reference. This is a pre-Composer release and should not be actively used.

[Unreleased]: https://github.com/Digital-Media/normform/compare/v1.2.3...HEAD
[1.2.3]: https://github.com/Digital-Media/normform/compare/v1.2.2...v1.2.3
[1.2.2]: https://github.com/Digital-Media/normform/compare/v1.2.1...v1.2.2
[1.2.1]: https://github.com/Digital-Media/normform/compare/v1.2.0...v1.2.1
[1.2.0]: https://github.com/Digital-Media/normform/compare/v1.1.0...v1.2.0
[1.1.0]: https://github.com/Digital-Media/normform/compare/v1.0.0...v1.1.0
[1.0.0]: https://github.com/Digital-Media/normform/compare/v0.1.0...v1.0.0
[0.1.0]: https://github.com/Digital-Media/normform/releases/tag/v0.1.0
