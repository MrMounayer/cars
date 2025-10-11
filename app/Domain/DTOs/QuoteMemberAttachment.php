<?php

namespace App\Domain\DTOs;

use Illuminate\Support\Collection;

class QuoteMemberAttachment
{

    public function __construct(protected string $collectionName, protected string $label, protected bool $isSingle, protected bool $isRequired)
    {
    }

    public static function all(): Collection
    {
        return collect([
            ['key' => 'profile-picture', 'label' => 'Profile Picture', 'single' => true, 'required' => true],
            ['key' => 'visa-picture', 'label' => 'VISA', 'single' => true, 'required' => true],
            ['key' => 'passport-picture', 'label' => 'Passport', 'single' => true, 'required' => true],
            ['key' => 'eid-front-picture', 'label' => 'Emirates ID front', 'single' => true, 'required' => true],
            ['key' => 'eid-back-picture', 'label' => 'Emirates ID back', 'single' => true, 'required' => false],
            ['key' => 'maf-member', 'label' => 'Medical Application Form', 'single' => true, 'required' => false],
            ['key' => 'other-documents', 'label' => 'Other Documents', 'single' => false, 'required' => false],
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
