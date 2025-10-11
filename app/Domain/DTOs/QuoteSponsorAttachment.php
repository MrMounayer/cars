<?php

namespace App\Domain\DTOs;

use Illuminate\Support\Collection;

class QuoteSponsorAttachment
{
    public function __construct(protected string $collectionName, protected string $label, protected bool $isSingle, protected bool $isRequired)
    {
    }

    public static function all($filters): Collection
    {
        return collect([
            ['key' => 'visa-picture', 'label' => 'VISA', 'single' => true, 'required' => false, 'type' => 1],
            ['key' => 'passport-picture', 'label' => 'Passport', 'single' => true, 'required' => false, 'type' => 1],
            ['key' => 'eid-front-picture', 'label' => 'Emirates ID front', 'single' => true, 'required' => true, 'type' => 1],
            ['key' => 'eid-back-picture', 'label' => 'Emirates ID back', 'single' => true, 'required' => false, 'type' => 1],
            ['key' => 'eid-front-picture-company', 'label' => 'Emirates ID front', 'single' => true, 'required' => false, 'type' => 2],
            ['key' => 'trading-license', 'label' => 'Trading License', 'single' => true, 'required' => true, 'type' => 2],
            ['key' => 'kyc', 'label' => 'KYC', 'single' => true, 'required' => true, 'type' => 2],
            ['key' => 'maf', 'label' => 'Medical Application Form', 'single' => true, 'required' => true, 'type' => 2],
            ['key' => 'cef', 'label' => 'Client Enrollment Form', 'single' => true, 'required' => true, 'type' => 2],
            ['key' => 'mol', 'label' => 'MOL', 'single' => true, 'required' => true, 'type' => 2],
            ['key' => 'moa', 'label' => 'Memorandum of Association (MOA)', 'single' => true, 'required' => true, 'type' => 2],
            ['key' => 'vat-certificate', 'label' => 'VAT Certificate', 'single' => true, 'required' => true, 'type' => 2],
            ['key' => 'company-establishment-card', 'label' => 'Establishment card of company', 'single' => true, 'required' => true, 'type' => 2],
        ])->filter(function ($value) use ($filters) {
                if ( isset($filters['type']) && intval($filters['type']) != $value['type']) {
                    return false;
                }
                if ( isset($filters['kyc']) && !$filters['kyc'] && $value['key'] == 'kyc') {
                    return false;
                }
                if ( isset($filters['maf']) && !$filters['maf'] && $value['key'] == 'maf') {
                    return false;
                }
                if ( isset($filters['cef']) && !$filters['cef'] && $value['key'] == 'cef') {
                    return false;
                }
                if ( isset($filters['mol']) && !$filters['mol'] && $value['key'] == 'mol') {
                    return false;
                }
                if ( isset($filters['moa']) && !$filters['moa'] && $value['key'] == 'moa') {
                    return false;
                }
                if ( isset($filters['vat-certificate']) && !$filters['vat-certificate'] && $value['key'] == 'vat-certificate') {
                    return false;
                }
                if ( isset($filters['company-establishment-card']) && !$filters['company-establishment-card'] && $value['key'] == 'company-establishment-card') {
                    return false;
                }
                return true;
            })
            ->map(function ($item){
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
