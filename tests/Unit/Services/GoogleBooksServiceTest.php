<?php

namespace Tests\Unit\Services;

use Illuminate\Support\Facades\Http;
use Tfevens\GoogleBooks\Tests\TestCase;
use Tfevens\GoogleBooks\Services\GoogleBooksService;
use Tfevens\GoogleBooks\DTOs\BookCollection;
use Tfevens\GoogleBooks\DTOs\Book;

class GoogleBooksServiceTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Http::preventStrayRequests();
 
        Http::fake([
            'https://www.googleapis.com/books/v1/volumes/*' => Http::response([
                'id' => 'abc123',
                'volumeInfo' => [
                    'title' => 'Test Book',
                    'authors' => ['Author Name'],
                    'pageCount' => 100,
                ]
            ],
            200),
            'https://www.googleapis.com/books/v1/volumes*' => Http::response([
                'items' => [
                    [
                        'id' => '1',
                        'volumeInfo' => [
                            'title' => 'Test Book 1',
                            'authors' => ['Author Name 1'],
                            'pageCount' => 100,
                        ]
                    ],
                    [
                        'id' => '2',
                        'volumeInfo' => [
                            'title' => 'Test Book 2',
                            'authors' => ['Author Name 2'],
                            'pageCount' => 100,
                        ]
                    ]
                ],
                'totalItems' => 1000000,
                'startIndex' => 0,
                'itemsPerPage' => 10,
            ],
            200)
        ]);
    }

    public function testSearchReturnsBookCollection()
    {
        $service = new GoogleBooksService();
        $result = $service->search('test');
        
        $this->assertInstanceOf(BookCollection::class, $result);
        $this->assertNotEmpty($result->getBooks());
    }

    public function testGetBookReturnsBook()
    {
        $service = new GoogleBooksService();
        $result = $service->getBook('1');
        
        $this->assertInstanceOf(Book::class, $result);
        $this->assertEquals('Test Book', $result->title);
    }

    public function testGetBooksByAuthorReturnsBookCollection()
    {
        $service = new GoogleBooksService();
        $result = $service->getBooksByAuthor('Author Name');

        $this->assertInstanceOf(BookCollection::class, $result);
        $this->assertEquals('Author Name 1', $result->getBooks()[0]->authors[0]);
    }

    // public function testGetBooksWithNoResultsReturnsEmptyCollection()
    // {
    //     Http::fake([
    //         'https://www.googleapis.com/books/v1/volumes/*' => Http::response([
    //             'id' => '1',
    //             'volumeInfo' => [
    //                 'title' => 'Test Book',
    //                 'authors' => ['Author Name'],
    //             ]
    //         ], 200)
    //     ]);

    //     $service = new GoogleBooksService();
        
    //     $result = $service->getBooksByAuthor('Nonexistent Author');
    //     $this->assertInstanceOf(BookCollection::class, $result);
    //     $this->assertCount(0, $result->items ?? []);
    // }
}