# A Laravel-centric way to interact with the Google Book API

[![Latest Version on Packagist](https://img.shields.io/packagist/v/tfevens/googlebooks.svg?style=flat-square)](https://packagist.org/packages/tfevens/googlebooks)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/tfevens/googlebooks/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/tfevens/googlebooks/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/tfevens/googlebooks/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/tfevens/googlebooks/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/tfevens/googlebooks.svg?style=flat-square)](https://packagist.org/packages/tfevens/googlebooks)

This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Installation

Install the package via composer:

```bash
composer require tfevens/googlebooks
```

Publish the configuration file:

```bash
php artisan vendor:publish --tag="googlebooks-config"
```

This is the contents of the published config file:

```php
return [
];
```

## Configuration

Add your Google Books API key to your `.env` file:

```env
GOOGLE_BOOKS_API_KEY=your_api_key_here
```

## Usage

### Basic Search

```php
use YourVendor\LaravelGoogleBooks\Facades\GoogleBooks;

// Search for books
$books = GoogleBooks::search('Laravel');

// Iterate through results
foreach ($books as $book) {
    echo $book->title . ' by ' . implode(', ', $book->authors) . PHP_EOL;
}
```

### Specific Searches

```php
// Search by author
$books = GoogleBooks::getBooksByAuthor('Taylor Otwell');

// Search by title
$books = GoogleBooks::getBooksByTitle('Clean Code');

// Search by subject
$books = GoogleBooks::getBooksBySubject('Programming');

// Search by ISBN
$books = GoogleBooks::getBooksByIsbn('9780134685991');
```

### Get Specific Book

```php
$book = GoogleBooks::getBook('volume_id_here');

if ($book) {
    echo "Title: " . $book->title . PHP_EOL;
    echo "Authors: " . implode(', ', $book->authors) . PHP_EOL;
    echo "Description: " . $book->description . PHP_EOL;
}
```

### Search Options

```php
$books = GoogleBooks::search('programming', [
    'maxResults' => 20,
    'startIndex' => 0,
    'printType' => 'books',
    'orderBy' => 'relevance'
]);
```

### Working with Book Objects

```php
$book = GoogleBooks::search('Laravel')->first();

// Get ISBN numbers
$isbn13 = $book->getIsbn13();
$isbn10 = $book->getIsbn10();

// Get images
$thumbnail = $book->getThumbnailUrl();
$smallImage = $book->getSmallImageUrl();

// Check availability
$isForSale = $book->isForSale();
$price = $book->getPrice();

// Convert to array
$bookArray = $book->toArray();
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Tim Fevens](https://github.com/tfevens)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
