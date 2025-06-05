<?php

namespace Tfevens\GoogleBooks;

use Tfevens\GoogleBooks\DTOs\Book;
use Tfevens\GoogleBooks\DTOs\BookCollection;
use Tfevens\GoogleBooks\Services\GoogleBooksService;

class GoogleBooks
{
    protected static GoogleBooksService $service;

    public static function getService(): GoogleBooksService
    {
        if (! isset(self::$service)) {
            self::$service = new GoogleBooksService;
        }

        return self::$service;
    }

    public static function search(string $query, array $options = []): BookCollection
    {
        return self::getService()->search($query, $options);
    }

    public static function getBook(string $volumeId): ?Book
    {
        return self::getService()->getBook($volumeId);
    }

    public static function getBooksByAuthor(string $author, array $options = []): BookCollection
    {
        return self::getService()->getBooksByAuthor($author, $options);
    }

    public static function getBooksByTitle(string $title, array $options = []): BookCollection
    {
        return self::getService()->getBooksByTitle($title, $options);
    }

    public static function getBooksBySubject(string $subject, array $options = []): BookCollection
    {
        return self::getService()->getBooksBySubject($subject, $options);
    }

    public static function getBookByIsbn(string $isbn, array $options = []): Book
    {
        return self::getService()->getBookByIsbn($isbn, $options);
    }
}
