<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Google Books API Key
    |--------------------------------------------------------------------------
    |
    | Your Google Books API key. You can get one from the Google Cloud Console.
    | This is optional but recommended for production use to avoid rate limits.
    |
    */
    'api_key' => env('GOOGLE_BOOKS_API_KEY', ''),

    /*
    |--------------------------------------------------------------------------
    | Google Books API Base URL
    |--------------------------------------------------------------------------
    |
    | The base URL for the Google Books API. You shouldn't need to change this
    | unless Google changes their API endpoint.
    |
    */
    'base_url' => 'https://www.googleapis.com/books/v1',

    /*
    |--------------------------------------------------------------------------
    | Default Options
    |--------------------------------------------------------------------------
    |
    | Default options that will be applied to all requests unless overridden.
    |
    */
    'defaults' => [
        'max_results' => 40,
        'print_type' => 'all', // all, books, magazines
        'projection' => 'full', // full, lite
    ],
];
