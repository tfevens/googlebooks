<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Http;
use Tfevens\GoogleBooks\Tests\TestCase;
use Tfevens\GoogleBooks\GoogleBooks;
use Tfevens\GoogleBooks\DTOs\Book;
use Tfevens\GoogleBooks\DTOs\BookCollection;

class GoogleBooksTest extends TestCase
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
        $result = GoogleBooks::search('test');
        
        $this->assertInstanceOf(BookCollection::class, $result);
        $this->assertNotEmpty($result->getBooks());
    }

    public function testGetBookReturnsBook()
    {
        $result = GoogleBooks::getBook('1');
        
        $this->assertInstanceOf(Book::class, $result);
        $this->assertEquals('Test Book', $result->title);
    }

    public function testGetBooksByAuthorReturnsBookCollection()
    {
        $result = GoogleBooks::getBooksByAuthor('Author Name');

        $this->assertInstanceOf(BookCollection::class, $result);
        $this->assertEquals('Author Name 1', $result->getBooks()[0]->authors[0]);
    }

    public function testGetBooksByTitleReturnsBookCollection()
    {
        $result = GoogleBooks::getBooksByTitle('Test Book');

        $this->assertInstanceOf(BookCollection::class, $result);
        $this->assertEquals('Test Book 1', $result->getBooks()[0]->title);
    }

    public function testGetBooksBySubjectReturnsBookCollection()
    {
        $result = GoogleBooks::getBooksBySubject('Programming');

        $this->assertInstanceOf(BookCollection::class, $result);
        $this->assertNotEmpty($result->getBooks());
    }

    public function testGetBookByIsbnReturnsBook()
    {
        $result = GoogleBooks::getBookByIsbn('9780134685991');

        $this->assertInstanceOf(Book::class, $result);
        $this->assertNotEmpty($result->title);
    }

    public function testServiceIsSingleton()
    {
        $service1 = GoogleBooks::getService();
        $service2 = GoogleBooks::getService();

        $this->assertSame($service1, $service2);
    }
} 