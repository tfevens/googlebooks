<?php

namespace Tfevens\GoogleBooks\Services;

use Illuminate\Support\Facades\Http;
use Tfevens\GoogleBooks\DTOs\Book;
use Tfevens\GoogleBooks\DTOs\BookCollection;
use Tfevens\GoogleBooks\Exceptions\GoogleBooksException;

class GoogleBooksService
{
    protected ?string $apiKey;

    protected string $baseUrl;

    public function __construct(?string $apiKey = null, string $baseUrl = 'https://www.googleapis.com/books/v1')
    {
        $this->apiKey = $apiKey;
        $this->baseUrl = $baseUrl;
    }

    /**
     * Search for books using a general query
     */
    public function search(string $query, array $options = []): BookCollection
    {
        $params = array_merge([
            'q' => $query,
            'maxResults' => 10,
            'startIndex' => 0,
        ], $options);

        if ($this->apiKey) {
            $params['key'] = $this->apiKey;
        }

        $response = $this->makeRequest('/volumes', $params);

        return BookCollection::fromApiResponse($response);
    }

    /**
     * Get a specific book by volume ID
     */
    public function getBook(string $volumeId): ?Book
    {
        $params = [];
        if ($this->apiKey) {
            $params['key'] = $this->apiKey;
        }

        $response = $this->makeRequest("/volumes/{$volumeId}", $params);

        return Book::fromApiResponse($response);
    }

    /**
     * Search for books by author
     */
    public function getBooksByAuthor(string $author, array $options = []): BookCollection
    {
        return $this->search("inauthor:{$author}", $options);
    }

    /**
     * Search for books by title
     */
    public function getBooksByTitle(string $title, array $options = []): BookCollection
    {
        return $this->search("intitle:{$title}", $options);
    }

    /**
     * Search for books by subject/category
     */
    public function getBooksBySubject(string $subject, array $options = []): BookCollection
    {
        return $this->search("subject:{$subject}", $options);
    }

    /**
     * Search for books by ISBN
     */
    public function getBookByIsbn(string $isbn, array $options = []): Book
    {
        return $this->search("isbn:{$isbn}", $options)->first();
    }

    /**
     * Make API request and return BookCollection
     */
    protected function makeRequest(string $endpoint, array $params): array
    {
        try {
            $response = Http::baseUrl($this->baseUrl)
                ->timeout(10)
                ->withHeaders([
                    'Accept' => 'application/json',
                    'User-Agent' => 'library.test/1.0',
                ])
                ->get($endpoint, $params)
                ->throw();

            return $response->json();
        } catch (\Exception $e) {
            throw new GoogleBooksException('API request failed: '.$e->getMessage(), 0, $e);
        }
    }
}
