<?php

namespace Tfevens\GoogleBooks\DTOs;

use Countable;
use Iterator;

class BookCollection implements Countable, Iterator
{
    protected array $books;

    protected int $position = 0;

    public function __construct(
        array $books,
        public readonly int $totalItems,
        public readonly int $startIndex,
        public readonly int $itemsPerPage
    ) {
        $this->books = array_map(fn ($book) => $book instanceof Book ? $book : Book::fromApiResponse($book), $books);
    }

    public static function fromApiResponse(array $data): self
    {
        $items = $data['items'] ?? [];
        $totalItems = $data['totalItems'] ?? 0;

        return new self(
            books: $items,
            totalItems: $totalItems,
            startIndex: 0,
            itemsPerPage: count($items)
        );
    }

    public function getBooks(): array
    {
        return $this->books;
    }

    public function first(): ?Book
    {
        return $this->books[0] ?? null;
    }

    public function isEmpty(): bool
    {
        return empty($this->books);
    }

    public function toArray(): array
    {
        return [
            'books' => array_map(fn (Book $book) => $book->toArray(), $this->books),
            'totalItems' => $this->totalItems,
            'startIndex' => $this->startIndex,
            'itemsPerPage' => $this->itemsPerPage,
        ];
    }

    // Iterator interface
    public function current(): Book
    {
        return $this->books[$this->position];
    }

    public function key(): int
    {
        return $this->position;
    }

    public function next(): void
    {
        $this->position++;
    }

    public function rewind(): void
    {
        $this->position = 0;
    }

    public function valid(): bool
    {
        return isset($this->books[$this->position]);
    }

    // Countable interface
    public function count(): int
    {
        return count($this->books);
    }
}
