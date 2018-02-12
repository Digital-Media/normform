# NormForm

*NormFom* is a simple template application for PHP form processing developed for PHP classes in the program [Media Technology and Design](https://www.fh-ooe.at/en/hagenberg-campus/studiengaenge/bachelor/media-technology-and-design/) at the University of Applied Sciences Upper Austria.

*NormForm* is designed as a single-page form validation and processing system, meaning that once the form is submitted, the page calls itself again and the process starts anew. It provides an Abstract class (`AbstractNormForm`) which implements a standard form display-validate-business logic process.

A set of CSS files, designed as CSS classes in spirit of the [BEM methodology](http://getbem.com/introduction/) is provided as well. It is being used in the examples and can be employed for projects that make use of *NormForm*.

## Basic Usage

To use *NormForm* create a class that inherits from `AbstractNormForm` and implement the required abstract methods `isValid()` (used for form validation) and `business()` (for business logic, once the form has been successfully submitted). Then create an instance of your new class and call the `normForm()` method to initiate the process.

To see *NormForm* in action, run ``/examples/NormFormExample.php``. It is a fully implemented example with a very simple form.

If you need a procedural (non object-oriented) version of *NormForm* you can use `/examples/norm_form_example.php` and modify it to your needs. This file has no other dependencies but is not as flexible as the object-oriented version.

## Technologies and Requirements

This code has been developed with the [XAMPP](https://www.apachefriends.org/) package in mind. Other development environments (MAMP, Vagrant images, Docker containers, etc.) will most likely as well but haven't been tested.

*You will need at least PHP 7.0 to use NormForm since it makes use of features such as type hinting.*

The following standards, conventions and technologies were used in the development of *NormForm*:

* [PHP 7.0](http://php.net/manual/en/migration70.new-features.php)
* [HTML 5.1](https://www.w3.org/TR/html51/)
* [CSS3](https://www.w3.org/Style/CSS/)
* [PSR-1: Basic Coding Standard](http://www.php-fig.org/psr/psr-1/)
* [PSR-2: Coding Style Guide](http://www.php-fig.org/psr/psr-2/)
* [PSR Naming Conventions](http://www.php-fig.org/bylaws/psr-naming-conventions/)
* [Smarty Template Engine](http://www.smarty.net/)
