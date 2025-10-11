<?php

namespace App\Domain\DTOs;

use Illuminate\Support\Collection;

class QuoteShareHolderAttachment
{
    public function __construct(protected string $collectionName, protected string $label, protected bool $isSingle, protected bool $isRequired)
    {
    }

    public static function all(): Collection
    {
        return collect([
            ['key' => 'passport-picture', 'label' => 'Passport', 'single' => true, 'required' => true],
            ['key' => 'eid-picture', 'label' => 'Emirates ID', 'single' => true, 'required' => true],
        ])->map(function ($item) {
            return new self($item['key'], $item['label'], $item['single'], $item['required']);
        });
    }

    public function getCollectionName(): string
    {
        return $this->collectionName;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function isSingle(): bool
    {
        return $this->isSingle;
    }

    public function isRequired(): bool
    {
        return $this->isRequired;
    }
}
