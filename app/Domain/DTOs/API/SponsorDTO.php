<?php

namespace App\Domain\DTOs\API;

use App\Domain\Helpers\MediaApiReceiverHelper;
use App\Models\Sponsor;
use App\Services\ICP\Enums\PolicyOwnerClass;
use App\Services\ICP\Enums\PolicyOwnerLegalType;
use App\Services\ICP\Enums\PolicyOwnerType;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class SponsorDTO
{
    private $uid;
    private $full_name;
    private $email;
    private $mobile;
    private $eid;
    private $unified_number;
    private $passport_number;
    private $trade_license_number;
    private $sponsor_type;
    private $sponsor_class;
    private $date_of_birth;
    private $eid_expiry_date;
    private $passport_expiry_date;
    private $legal_type;
    private $trade_license_number_expiry_date;
    private $establishment_card_number;
    private $auth_signatory_name;
    private $auth_signatory_eid;
    private $country_id;
    private $region_id;
    private $created_at;
    private $updated_at;
    private $quote_id;
    private $attachments;

    public function __construct(protected $data, protected $isUpdate = false)
    {
        if ($isUpdate) {
            $this->fillForUpdate($data);
        } else {
            $this->fillForCreate($data);
        }
    }

    public function toArray(): array
    {
        return [
            'uid' => $this->uid,
            'full_name' => $this->full_name,
            'email' => $this->email,
            'mobile' => $this->mobile,
            'eid' => $this->eid,
            'unified_number' => $this->unified_number,
            'passport_number' => $this->passport_number,
            'trade_license_number' => $this->trade_license_number,
            'sponsor_type' => $this->sponsor_type,
            'sponsor_class' => $this->sponsor_class,
            'date_of_birth' => $this->date_of_birth,
            'eid_expiry_date' => $this->eid_expiry_date,
            'passport_expiry_date' => $this->passport_expiry_date,
            'legal_type' => $this->legal_type,
            'trade_license_number_expiry_date' => $this->trade_license_number_expiry_date,
            'establishment_card_number' => $this->establishment_card_number,
            'auth_signatory_name' => $this->auth_signatory_name,
            'auth_signatory_eid' => $this->auth_signatory_eid,
            'country_id' => $this->country_id,
            'region_id' => $this->region_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'attachments' => $this->attachments
        ];
    }

    public function validate($payload, $rules)
    {
        try {
            Validator::validate($payload, $rules);
        } catch (ValidationException $exception) {
            throw $exception;
        }
    }

    public function fill(array $data){
        $attachments = $data['attachments'] ?? null;
        if (isset($data['uid'])){
            $attachments = match (PolicyOwnerType::tryFrom($data['sponsor_type'])) {
                PolicyOwnerType::PrincipalAkaSponsor => [
                    "visa" => route('getMedia', ['record' => 'Sponsor', 'uid' => $data['uid'], 'media' => 'visa']),
                    "passport" => route('getMedia', ['record' => 'Sponsor', 'uid' => $data['uid'], 'media' => 'passport']),
                    "eid_front" => route('getMedia', ['record' => 'Sponsor', 'uid' => $data['uid'], 'media' => 'emirate_id_front']),
                    "eid_back" => route('getMedia', ['record' => 'Sponsor', 'uid' => $data['uid'], 'media' => 'emirate_id_back']),
                ],
                default => [
                    "eid_front_company" => route('getMedia', ['record' => 'Sponsor', 'uid' => $data['uid'], 'media' => 'emirate_id_front_company']),
                    "trading_license" => route('getMedia', ['record' => 'Sponsor', 'uid' => $data['uid'], 'media' => 'trading_license']),
                    /*"kyc" => route('getMedia', ['record' => 'Sponsor', 'uid' => $data['uid'], 'media' => 'kyc']),
                    "maf" => route('getMedia', ['record' => 'Sponsor', 'uid' => $data['uid'], 'media' => 'maf']),
                    "cef" => route('getMedia', ['record' => 'Sponsor', 'uid' => $data['uid'], 'media' => 'cef']),*/ // TODO
                ]
            };
        }
        $this->uid = $data['uid'] ?? null;
        $this->full_name = $data['full_name'] ?? null;
        $this->email = $data['email'] ?? null;
        $this->mobile = $data['mobile'] ?? null;
        $this->eid = $data['eid'] ?? null;
        $this->unified_number = $data['unified_number'] ?? null;
        $this->passport_number = $data['passport_number'] ?? null;
        $this->trade_license_number = $data['trade_license_number'] ?? null;
        $this->sponsor_type = $data['sponsor_type'] ?? null;
        $this->sponsor_class = $data['sponsor_class'] ?? null;
        $this->date_of_birth = $data['date_of_birth'] ?? null;
        $this->eid_expiry_date = $data['eid_expiry_date'] ?? null;
        $this->passport_expiry_date = $data['passport_expiry_date'] ?? null;
        $this->legal_type = $data['legal_type'] ?? null;
        $this->trade_license_number_expiry_date = $data['trade_license_number_expiry_date'] ?? null;
        $this->establishment_card_number = $data['establishment_card_number'] ?? null;
        $this->auth_signatory_name = $data['auth_signatory_name'] ?? null;
        $this->auth_signatory_eid = $data['auth_signatory_eid'] ?? null;
        $this->country_id = $data['country_id'] ?? null;
        $this->region_id = $data['region_id'] ?? null;
        $this->created_at = $data['created_at'] ?? null;
        $this->updated_at = $data['updated_at'] ?? null;
        $this->quote_id = $data['quote_id'] ?? null;
        $this->attachments = $attachments;
    }

    public function fillForCreate(array $data)
    {
        $this->uid = $data['uid'] ?? null;
        $this->full_name = $data['full_name'] ?? null;
        $this->email = $data['email'] ?? null;
        $this->mobile = $data['mobile'] ?? null;
        $this->eid = $data['eid'] ?? null;
        $this->unified_number = $data['unified_number'] ?? null;
        $this->passport_number = $data['passport_number'] ?? null;
        $this->trade_license_number = $data['trade_license_number'] ?? null;
        $this->sponsor_type = $data['sponsor_type'] ?? null;
        $this->sponsor_class = $data['sponsor_class'] ?? null;
        $this->date_of_birth = $data['date_of_birth'] ?? null;
        $this->eid_expiry_date = $data['eid_expiry_date'] ?? null;
        $this->passport_expiry_date = $data['passport_expiry_date'] ?? null;
        $this->legal_type = $data['legal_type'] ?? null;
        $this->trade_license_number_expiry_date = $data['trade_license_number_expiry_date'] ?? null;
        $this->establishment_card_number = $data['establishment_card_number'] ?? null;
        $this->auth_signatory_name = $data['auth_signatory_name'] ?? null;
        $this->auth_signatory_eid = $data['auth_signatory_eid'] ?? null;
        $this->country_id = $data['country_id'] ?? null;
        $this->region_id = $data['region_id'] ?? null;
        $this->created_at = $data['created_at'] ?? null;
        $this->updated_at = $data['updated_at'] ?? null;
        $this->quote_id = $data['quote_id'] ?? null;
        $this->attachments = $data['attachments'] ?? null;

        // Handle attachments for creation
        if (isset($data['uid'])) {
            $this->attachments = $this->handleAttachmentsForCreate($data);
        }
    }

    public function fillForUpdate(array $data)
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }

        // Handle attachments separately
        if (isset($data['attachments'])) {
            $this->attachments = $data['attachments'];
        }
    }

    private function handleAttachmentsForCreate(array $data)
    {
        $attachments = [];
        if (isset($data['uid'])) {
            $attachments = match (PolicyOwnerType::tryFrom($data['sponsor_type'])) {
                PolicyOwnerType::PrincipalAkaSponsor => [
                    "visa" => route('getMedia', ['record' => 'Sponsor', 'uid' => $data['uid'], 'media' => 'visa']),
                    "passport" => route('getMedia', ['record' => 'Sponsor', 'uid' => $data['uid'], 'media' => 'passport']),
                    "eid_front" => route('getMedia', ['record' => 'Sponsor', 'uid' => $data['uid'], 'media' => 'emirate_id_front']),
                    "eid_back" => route('getMedia', ['record' => 'Sponsor', 'uid' => $data['uid'], 'media' => 'emirate_id_back']),
                ],
                default => [
                    "eid_front_company" => route('getMedia', ['record' => 'Sponsor', 'uid' => $data['uid'], 'media' => 'emirate_id_front_company']),
                    "trading_license" => route('getMedia', ['record' => 'Sponsor', 'uid' => $data['uid'], 'media' => 'trading_license']),
                ]
            };
        }
        return $attachments;
    }

    public function getPayloadForCreation(): array
    {
        $payload =  [
            "full_name" => $this->full_name,
            "email" => $this->email,
            "mobile" => $this->mobile,
            "eid" => $this->eid,
            "unified_number" => $this->unified_number,
            "passport_number" => $this->passport_number,
            "trade_license_number" => $this->trade_license_number,
            "sponsor_type" => $this->sponsor_type,
            "sponsor_class" => $this->sponsor_class,
            "date_of_birth" => $this->date_of_birth,
            "eid_expiry_date" => $this->eid_expiry_date,
            "passport_expiry_date" => $this->passport_expiry_date,
            "legal_type" => $this->legal_type,
            "trade_license_number_expiry_date" => $this->trade_license_number_expiry_date,
            "establishment_card_number" => $this->establishment_card_number,
            "auth_signatory_name" => $this->auth_signatory_name,
            "auth_signatory_eid" => $this->auth_signatory_eid,
            "country_id" => $this->country_id,
            "region_id" => $this->region_id,
            "quote_id" => $this->quote_id,
            "attachments" => $this->attachments
        ];

        $this->validate($payload, [
            'sponsor_type' => ['required', Rule::enum(PolicyOwnerType::class)],
            'full_name' => ['required','string','regex:/^\s*[a-zA-Z0-9]+(\s+[a-zA-Z0-9]+)*\s*$/'],
            'email' => ['required','email'],
            'mobile' => ['required','regex:/^0\d{9}$/'],
            'eid' => ['nullable','required_if:sponsor_type,1','regex:/^784\d{12}$/'],
            'unified_number' => ['nullable','digits_between:5,9'],
            'passport_number' => ['nullable','regex:/^[a-zA-Z0-9]*$/'],
            'trade_license_number' => ['nullable','required_if:sponsor_type,2','regex:/^[a-zA-Z0-9]+$/'],
            'sponsor_class' => ['nullable', Rule::enum(PolicyOwnerClass::class)],
            'date_of_birth' => ['nullable','date'],
            'eid_expiry_date' => ['nullable','date'],
            'passport_expiry_date' => ['nullable','date'],
            'legal_type' => ['nullable',Rule::enum(PolicyOwnerLegalType::class)],
            'trade_license_number_expiry_date' => ['nullable','date'],
            'establishment_card_number' => ['nullable',],
            'auth_signatory_name' => ['nullable',],
            'auth_signatory_eid' => ['nullable',],
            'country_id' => ['nullable', 'integer', 'exists:countries,id'],
            'region_id' => ['nullable','integer','exists:regions,id'],
            'quote_id' => ['required'],
            'attachments.visa' => ['nullable'],
            'attachments.passport' => ['nullable'],
            'attachments.eid_front' => ['nullable','required_if:sponsor_type,1'],
            'attachments.eid_back' => ['nullable'],
            'attachments.eid_front_company' => ['nullable'],
            'attachments.trading_license' => ['nullable','required_if:sponsor_type,2'],
        ]);
        unset($payload['attachments']);
        return $payload;
    }

    public function getPayloadForUpdate(): array
    {
        $payload = [
            "full_name" => $this->full_name,
            "email" => $this->email,
            "mobile" => $this->mobile,
            "eid" => $this->eid,
            "unified_number" => $this->unified_number,
            "passport_number" => $this->passport_number,
            "trade_license_number" => $this->trade_license_number,
            "sponsor_type" => $this->sponsor_type,
            "sponsor_class" => $this->sponsor_class,
            "date_of_birth" => $this->date_of_birth,
            "eid_expiry_date" => $this->eid_expiry_date,
            "passport_expiry_date" => $this->passport_expiry_date,
            "legal_type" => $this->legal_type,
            "trade_license_number_expiry_date" => $this->trade_license_number_expiry_date,
            "establishment_card_number" => $this->establishment_card_number,
            "auth_signatory_name" => $this->auth_signatory_name,
            "auth_signatory_eid" => $this->auth_signatory_eid,
            "country_id" => $this->country_id,
            "region_id" => $this->region_id,
        ];

        $validationRules = [
            'sponsor_type' => ['sometimes', Rule::enum(PolicyOwnerType::class)],
            'full_name' => ['sometimes', 'string', 'regex:/^\s*[a-zA-Z0-9]+(\s+[a-zA-Z0-9]+)*\s*$/'],
            'email' => ['sometimes', 'email'],
            'mobile' => ['sometimes', 'regex:/^0\d{9}$/'],
            'eid' => ['nullable', 'sometimes', 'regex:/^784\d{12}$/'],
            'unified_number' => ['nullable', 'sometimes', 'digits_between:5,9'],
            'passport_number' => ['nullable', 'sometimes', 'regex:/^[a-zA-Z0-9]*$/'],
            'trade_license_number' => ['nullable', 'sometimes', 'regex:/^[a-zA-Z0-9]+$/'],
            'sponsor_class' => ['nullable', 'sometimes', Rule::enum(PolicyOwnerClass::class)],
            'date_of_birth' => ['nullable', 'sometimes', 'date'],
            'eid_expiry_date' => ['nullable', 'sometimes', 'date'],
            'passport_expiry_date' => ['nullable', 'sometimes', 'date'],
            'legal_type' => ['nullable', 'sometimes', Rule::enum(PolicyOwnerLegalType::class)],
            'trade_license_number_expiry_date' => ['nullable', 'sometimes', 'date'],
            'establishment_card_number' => ['nullable', 'sometimes'],
            'auth_signatory_name' => ['nullable', 'sometimes'],
            'auth_signatory_eid' => ['nullable', 'sometimes'],
            'country_id' => ['nullable', 'sometimes', 'integer', 'exists:countries,id'],
            'region_id' => ['nullable', 'sometimes', 'integer', 'exists:regions,id'],
            'attachments' => ['sometimes', 'array'],
            'attachments.visa' => ['nullable', 'sometimes', 'url'],
            'attachments.passport' => ['nullable', 'sometimes', 'url'],
            'attachments.eid_front' => ['nullable', 'sometimes', 'url'],
            'attachments.eid_back' => ['nullable', 'sometimes', 'url'],
            'attachments.eid_front_company' => ['nullable', 'sometimes', 'url'],
            'attachments.trading_license' => ['nullable', 'sometimes', 'url'],
        ];

        $this->validate($payload, $validationRules);

        return array_filter($payload, function ($value) {
            return $value !== null;
        });
    }

    protected function updateAttachments(Sponsor $sponsor)
    {
        foreach ($this->attachments as $key => $attachment_url) {
            $mappedAttachment = $this->mapAttachement($key);
            if (!empty($mappedAttachment)) {
                MediaApiReceiverHelper::handleUrl(
                    $attachment_url,
                    "Sponsor",
                    $sponsor->uid,
                    $mappedAttachment['collection'],
                    $mappedAttachment['type']
                );
            }
        }
    }

    public function create()
    {
        $createPayload = $this->getPayloadForCreation();
        // create
        $sponsor = Sponsor::create($createPayload);
        // create attachments
        if ($sponsor) {
            $this->createAttachments($sponsor);
        }
        return $this;
    }

    public function update(Sponsor $sponsor)
    {
        $updatePayload = $this->getPayloadForUpdate();

        // Update sponsor attributes
        $sponsor->update($updatePayload);

        // Update attachments
        if (isset($this->attachments)) {
            $this->updateAttachments($sponsor);
        }

        return $this;
    }

    private function createAttachments(Sponsor $sponsor)
    {
        if ($this->attachments) {
            foreach ($this->attachments as $key => $attachment_url) {
                $mappedAttachment = $this->mapAttachement($key);
                if (!empty($mappedAttachment)) {
                    MediaApiReceiverHelper::handleUrl(
                        $attachment_url,
                        "Sponsor",
                        $sponsor->uid,
                        $mappedAttachment['collection'],
                        $mappedAttachment['type']
                    );
                }
            }
        }
    }

    public function setQuoteId(int $quoteId){
        $this->quote_id = $quoteId;
    }

    protected function mapAttachement($key){
        return match ($key) {
            'visa' => [
                'collection' => 'visa-picture',
                'type' => 'document',
            ],
            'passport' => [
                'collection' => 'passport-picture',
                'type' => 'document',
            ],
            'eid_front' => [
                'collection' => 'eid-front-picture',
                'type' => 'document',
            ],
            'eid_back' => [
                'collection' => 'eid-back-picture',
                'type' => 'document',
            ],
            'eid_front_company' => [
                'collection' => 'eid-front-company-picture',
                'type' => 'document',
            ],
            'trading_license' => [
                'collection' => 'trading-license-picture',
                'type' => 'document',
            ],
            default => []
        };
    }

}
