# NormForm

*NormFom* is a simple template application for PHP form processing developed for PHP classes in the program [Media Technology and Design](https://www.fh-ooe.at/en/hagenberg-campus/studiengaenge/bachelor/media-technology-and-design/) at the [University of Applied Sciences Upper Austria](https://www.fh-ooe.at/en/hagenberg-campus/). It is primarily designed for educational purposes (learning object oriented PHP, form processing and templating languages). Use it for "public" applications at your own risk.

*NormForm* is designed as a single-page form validation and processing system, meaning that once the form is submitted, the page calls itself again and the process starts anew. It provides an abstract class (`AbstractNormForm`) which implements a standard form display-validate-business logic process along with classes for form parameter management and display.

## Installation

The recommended way to use *NormForm* in your project is through Composer:

    composer require fhooe/normform

Alternatively, you can use the [NormForm Skeleton](https://github.com/Digital-Media/normform-skeleton) project that gives you a fully working example built upon *NormForm* (including a template file and CSS):

    composer create-project fhooe/normform-skeleton path/to/install

Composer will then create a project in the `path/to/install` directory.

## Basic Usage

To use *NormForm* create a class that inherits from `AbstractNormForm` and implement the required abstract methods `isValid()` (used for form validation) and `business()` (for business logic, once the form has been successfully submitted). Then create an instance of your new class and call the `normForm()` method to initiate the process (preferrably in a separate file such as `index.php`).

## Contributing

If you'd like to contribute, please refer to [CONTRIBUTING](https://github.com/Digital-Media/normform/blob/master/CONTRIBUTING.md) for details.

## License

NormForm is licensed under the MIT license. See [LICENSE](https://github.com/Digital-Media/normform/blob/master/LICENSE) for more information.

## More Information

- [API Documentation](https://digital-media.github.io/normform/)
