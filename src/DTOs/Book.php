<?php

namespace Tfevens\GoogleBooks\DTOs;

class Book
{
    public function __construct(
        public readonly string $id,
        public readonly string $title,
        public readonly array $authors,
        public readonly ?string $description,
        public readonly array $categories,
        public readonly ?string $publishedDate,
        public readonly ?string $publisher,
        public readonly ?int $pageCount,
        public readonly array $industryIdentifiers,
        public readonly ?string $language,
        public readonly ?array $imageLinks,
        public readonly ?string $previewLink,
        public readonly ?string $infoLink,
        public readonly ?array $saleInfo,
        public readonly ?float $averageRating,
        public readonly ?int $ratingsCount,
        public readonly ?string $kind,
        public readonly ?string $etag,
        public readonly ?string $selfLink,
        public readonly ?array $readingModes,
        public readonly ?string $printType,
        public readonly ?string $maturityRating,
        public readonly ?bool $allowAnonLogging,
        public readonly ?string $contentVersion,
        public readonly ?array $panelizationSummary,
        public readonly ?string $canonicalVolumeLink,
        public readonly ?array $accessInfo,
        public readonly ?array $searchInfo,
        public readonly array $raw
    ) {}

    public static function fromApiResponse(array $data): self
    {
        $volumeInfo = $data['volumeInfo'] ?? [];
        $saleInfo = $data['saleInfo'] ?? null;

        return new self(
            id: $data['id'] ?? '',
            title: $volumeInfo['title'] ?? '',
            authors: $volumeInfo['authors'] ?? [],
            description: $volumeInfo['description'] ?? null,
            categories: $volumeInfo['categories'] ?? [],
            publishedDate: $volumeInfo['publishedDate'] ?? null,
            publisher: $volumeInfo['publisher'] ?? null,
            pageCount: $volumeInfo['pageCount'] ?? null,
            industryIdentifiers: $volumeInfo['industryIdentifiers'] ?? [],
            language: $volumeInfo['language'] ?? null,
            imageLinks: $volumeInfo['imageLinks'] ?? null,
            previewLink: $volumeInfo['previewLink'] ?? null,
            infoLink: $volumeInfo['infoLink'] ?? null,
            saleInfo: $saleInfo,
            averageRating: $volumeInfo['averageRating'] ?? null,
            ratingsCount: $volumeInfo['ratingsCount'] ?? null,
            kind: $data['kind'] ?? null,
            etag: $data['etag'] ?? null,
            selfLink: $data['selfLink'] ?? null,
            readingModes: $volumeInfo['readingModes'] ?? null,
            printType: $volumeInfo['printType'] ?? null,
            maturityRating: $volumeInfo['maturityRating'] ?? null,
            allowAnonLogging: $volumeInfo['allowAnonLogging'] ?? null,
            contentVersion: $volumeInfo['contentVersion'] ?? null,
            panelizationSummary: $volumeInfo['panelizationSummary'] ?? null,
            canonicalVolumeLink: $volumeInfo['canonicalVolumeLink'] ?? null,
            accessInfo: $data['accessInfo'] ?? null,
            searchInfo: $data['searchInfo'] ?? null,
            raw: $data
        );
    }

    /**
     * Get the book's ISBN-13 if available
     */
    public function getIsbn13(): ?string
    {
        foreach ($this->industryIdentifiers as $identifier) {
            if ($identifier['type'] === 'ISBN_13') {
                return $identifier['identifier'];
            }
        }

        return null;
    }

    /**
     * Get the book's ISBN-10 if available
     */
    public function getIsbn10(): ?string
    {
        foreach ($this->industryIdentifiers as $identifier) {
            if ($identifier['type'] === 'ISBN_10') {
                return $identifier['identifier'];
            }
        }

        return null;
    }

    /**
     * Get the primary author
     */
    public function getPrimaryAuthor(): ?string
    {
        return $this->authors[0] ?? null;
    }

    /**
     * Get thumbnail image URL
     */
    public function getImages(): ?array
    {
        return $this->imageLinks;
    }

    /**
     * Get thumbnail image URL
     */
    public function getThumbnailUrl(): ?string
    {
        return $this->getImages()['thumbnail'] ?? null;
    }

    /**
     * Get small image URL
     */
    public function getSmallImageUrl(): ?string
    {
        return $this->getImages()['smallThumbnail'] ?? null;
    }

    /**
     * Check if the book is available for sale
     */
    public function isForSale(): bool
    {
        return ($this->saleInfo['saleability'] ?? '') === 'FOR_SALE';
    }

    /**
     * Get the book's price if available
     */
    public function getPrice(): ?array
    {
        return $this->saleInfo['listPrice'] ?? null;
    }

    /**
     * Convert to array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'authors' => $this->authors,
            'description' => $this->description,
            'categories' => $this->categories,
            'published_date' => $this->publishedDate,
            'publisher' => $this->publisher,
            'page_count' => $this->pageCount,
            'industry_identifiers' => $this->industryIdentifiers,
            'language' => $this->language,
            'image_links' => $this->imageLinks,
            'preview_link' => $this->previewLink,
            'info_link' => $this->infoLink,
            'sale_info' => $this->saleInfo,
            'average_rating' => $this->averageRating,
            'ratings_count' => $this->ratingsCount,
            'kind' => $this->kind,
            'etag' => $this->etag,
            'self_link' => $this->selfLink,
            'reading_modes' => $this->readingModes,
            'print_type' => $this->printType,
            'maturity_rating' => $this->maturityRating,
            'allow_anon_logging' => $this->allowAnonLogging,
            'content_version' => $this->contentVersion,
            'panelization_summary' => $this->panelizationSummary,
            'canonical_volume_link' => $this->canonicalVolumeLink,
            'access_info' => $this->accessInfo,
            'search_info' => $this->searchInfo,
        ];
    }
}
