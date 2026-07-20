<?php

declare(strict_types=1);

namespace App\DTO;

final readonly class ProductDTO
{
    public function __construct(
        public string $name,
        public string $slug,
        public string $description,
        public float $price,
        public ?float $discountPrice,
        public int $stock,
        public string $sku,
        public bool $isActive,
        public array $categoryIds,
        public array $images,
        public array $attributes,
        public ?string $brandId,
        public array $variants = [],
        public array $meta = [],
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            slug: $data['slug'],
            description: $data['description'],
            price: (float) $data['price'],
            discountPrice: isset($data['discount_price']) ? (float) $data['discount_price'] : null,
            stock: (int) $data['stock'],
            sku: $data['sku'],
            isActive: (bool) ($data['is_active'] ?? true),
            categoryIds: $data['category_ids'] ?? [],
            images: $data['images'] ?? [],
            attributes: $data['attributes'] ?? [],
            brandId: $data['brand_id'] ?? null,
            variants: $data['variants'] ?? [],
            meta: $data['meta'] ?? [],
        );
    }
}
