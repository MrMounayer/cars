<?php

namespace App\Domain\DTOs\API;

use App\Domain\Helpers\MediaApiReceiverHelper;
use App\Models\Country;
use App\Models\Member;
use App\Models\Product;
use App\Models\ProductPlan;
use App\Models\Region;
use App\Models\ResidenceLocation;
use App\Models\SubRegion;
use App\Services\ICP\Enums\MemberGender;
use App\Services\ICP\Enums\MemberMaritalStatus;
use App\Services\ICP\Enums\MemberRelationshipWithSponsor;
use App\Services\ICP\Enums\MemberSalary;
use App\Services\ICP\Enums\MemberType;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class MemberDTO
{
    private $uid;
    private $first_name;
    private $middle_name;
    private $last_name;
    private $relation_type;
    private $eid;
    private $eid_application_no;
    private $email;
    private $unified_number;
    private $residence_file_no;
    private $type;
    private $profession;
    private $date_of_birth;
    private $gender;
    private $nationality;
    private $marital_status;
    private $passport_number;
    private $salary;
    private $height;
    private $weight;
    private $price;
    private $vat_percentage;
    private $price_with_vat;
    private $slash_data_fees;
    private $total;
    private $country_id;
    private $residence_location_id;
    private $occupation;
    private $region_id;
    private $sub_region_id;
    private $e_card;
    private $birth_certificate_number;
    private $deleted_at;
    private $created_at;
    private $updated_at;
    private $quote_id;
    private $product;
    private $attachments;
    private $policy_attachments;

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
            'first_name' => $this->first_name,
            'middle_name' => $this->middle_name,
            'last_name' => $this->last_name,
            'relation_type' => $this->relation_type,
            'eid' => $this->eid,
            'eid_application_no' => $this->eid_application_no,
            'email' => $this->email,
            'unified_number' => $this->unified_number,
            'residence_file_no' => $this->residence_file_no,
            'type' => $this->type,
            'profession' => $this->profession,
            'date_of_birth' => $this->date_of_birth,
            'gender' => $this->gender,
            'nationality' => $this->nationality,
            'marital_status' => $this->marital_status,
            'passport_number' => $this->passport_number,
            'salary' => $this->salary,
            'height' => $this->height,
            'weight' => $this->weight,
            'price' => $this->price,
            'vat_percentage' => $this->vat_percentage,
            'price_with_vat' => $this->price_with_vat,
            'slash_data_fees' => $this->slash_data_fees,
            'total' => $this->total,
            'country_id' => $this->country_id,
            'residence_location_id' => $this->residence_location_id,
            'occupation' => $this->occupation,
            'region_id' => $this->region_id,
            'sub_region_id' => $this->sub_region_id,
            'e_card' => $this->e_card,
            'birth_certificate_number' => $this->birth_certificate_number,
            'deleted_at' => $this->deleted_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'attachments' => $this->attachments,
            'policy_attachments' => $this->policy_attachments,
        ];
    }

    public function validate($payload, $rules)
    {
        // TODO: add validation
        try {
            Validator::validate($payload, $rules);
        } catch (ValidationException $exception) {
            throw $exception;
        }
    }

    public function fillForCreate(array $data){
        $attachments = $data['attachments'] ?? null;
        $policy_attachments = $data['policy_attachments'] ?? null;
        if (isset($data['uid'])){
            $attachments = [
                "profile" => route('getMedia', ['record' => 'Member', 'uid' =>  $data['uid'], 'media' => 'profile_picture']),
                "visa" => route('getMedia', ['record' => 'Member', 'uid' =>  $data['uid'], 'media' => 'visa']),
                "passport" => route('getMedia', ['record' => 'Member', 'uid' =>  $data['uid'], 'media' => 'passport']),
                "eid_front" => route('getMedia', ['record' => 'Member', 'uid' =>  $data['uid'], 'media' => 'emirate_id_front']),
                "eid_back" => route('getMedia', ['record' => 'Member', 'uid' =>  $data['uid'], 'media' => 'emirate_id_back']),
                "other" => route('getMedia', ['record' => 'Member', 'uid' =>  $data['uid'], 'media' => 'other_documents']),
            ];
            $member = Member::query()->where('uid', $data['uid'])->first();
            if ($member->quote->isConfirmed() && $member->quote->policy->generation_completed_at) {
                $policy_attachments = [
                    "COI" => route('getMedia', ['record' => 'Member', 'uid' => $data['uid'], 'media' => 'cio_doc']),
                    "ecard" => route('getMedia', ['record' => 'Member', 'uid' => $data['uid'], 'media' => 'e_card_doc']),
                    "invoice" => route('getMedia', ['record' => 'Quote', 'uid' => $member->quote->uid, 'media' => 'invoice']),
                    "tob" => route('getMedia', ['record' => 'Product', 'uid' => $member->quote->product->uid, 'media' => 'tob']),
                    "network" => route('getMedia', ['record' => 'Network', 'uid' => $member->quote->product->network->uid, 'media' => 'network_attachment']),
                ];
            }
        }

        $this->uid = $data['uid']?? null;
        $this->first_name = $data['first_name']?? null;
        $this->middle_name = $data['middle_name']?? null;
        $this->last_name = $data['last_name']?? null;
        $this->relation_type = $data['relation_type']?? null;
        $this->eid = $data['eid']?? null;
        $this->eid_application_no = $data['eid_application_no']?? null;
        $this->email = $data['email']?? null;
        $this->unified_number = $data['unified_number']?? null;
        $this->residence_file_no = $data['residence_file_no']?? null;
        $this->type = $data['type']?? null;
        $this->profession = $data['profession']?? null;
        $this->date_of_birth = $data['date_of_birth']?? null;
        $this->gender = $data['gender']?? null;
        $this->nationality = $data['nationality']?? null;
        $this->marital_status = $data['marital_status']?? null;
        $this->passport_number = $data['passport_number']?? null;
        $this->salary = $data['salary']?? null;
        $this->height = $data['height']?? null;
        $this->weight = $data['weight']?? null;
        $this->price = $data['price']?? null;
        $this->vat_percentage = $data['vat_percentage']?? null;
        $this->price_with_vat = $data['price_with_vat']?? null;
        $this->slash_data_fees = $data['slash_data_fees']?? null;
        $this->total = $data['total']?? null;
        $this->country_id = $data['country_id']?? null;
        $this->residence_location_id = $data['residence_location_id']?? null;
        $this->occupation = $data['occupation']?? null;
        $this->region_id = $data['region_id']?? null;
        $this->sub_region_id = $data['sub_region_id']?? null;
        $this->e_card = $data['e_card']?? null;
        $this->birth_certificate_number = $data['birth_certificate_number']?? null;
        $this->deleted_at = $data['deleted_at']?? null;
        $this->created_at = $data['created_at']?? null;
        $this->updated_at = $data['updated_at']?? null;
        $this->quote_id = $data['quote_id']?? null;
        $this->attachments = $attachments;
        $this->policy_attachments = $policy_attachments;
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

    public function getPayloadForCreation(): array
    {
        if($this->product){
            $age = Carbon::parse($this->date_of_birth)->age;
            try {
                $productPlan = ProductPlan::query()
                    ->where('product_id',$this->product->id)
                    ->forAge($age)
                    ->firstOrFail();
            } catch (\Exception $e) {
                throw new \Exception("Couldn't find suitable product plan for this member, please check the age");
            }
            $this->price = $productPlan?->price ?? 0;
            $this->vat_percentage = $productPlan?->vat_percentage ?? 0;
            $this->price_with_vat = $productPlan?->price_with_vat ?? 0;
            $this->slash_data_fees = $productPlan?->slash_data_fees ?? 0;
            $this->total = $productPlan?->total ?? 0;
        }
        try {
            $residence_location = ResidenceLocation::where('id', $this->residence_location_id)->firstOrFail();
        } catch (\Exception $e) {
            throw new \Exception("Couldn't find residence location with id {$this->region_id}");
        }

        $payload =  [
            "first_name" => $this->first_name,
            "middle_name" => $this->middle_name,
            "last_name" => $this->last_name,
            "relation_type" => MemberRelationshipWithSponsor::tryFrom($this->relation_type),
            "eid" => $this->eid,
            "eid_application_no" => $this->eid_application_no,
            "email" => $this->email,
            "unified_number" => $this->unified_number,
            "residence_file_no" => $this->residence_file_no,
            "type" => MemberType::tryFrom($this->type),
            "profession" => $this->profession,
            "date_of_birth" => $this->date_of_birth,
            "gender" => MemberGender::tryFrom($this->gender),
            "nationality" => $this->nationality,
            "marital_status" => MemberMaritalStatus::tryFrom($this->marital_status),
            "passport_number" => $this->passport_number,
            "salary" => MemberSalary::tryFrom($this->salary),
            "height" => $this->height,
            "weight" => $this->weight,
            "price" => $this->price,
            "vat_percentage" => $this->vat_percentage,
            "price_with_vat" => $this->price_with_vat,
            "slash_data_fees" => $this->slash_data_fees,
            "total" => $this->total,
            "country_id" => $this->country_id,
            "residence_location_id" => $residence_location->id,
            "occupation" => $this->occupation,
            "region_id" => $this->region_id,
            "sub_region_id" => $this->sub_region_id,
            "birth_certificate_number" => $this->birth_certificate_number,
            "deleted_at" => $this->deleted_at,
            "quote_id" => $this->quote_id,
            "attachments" => $this->attachments
        ];

        $this->validate($payload, [
            'first_name' => ['required', 'regex:/^\s*[a-zA-Z]+(\s+[a-zA-Z]+)*\s*$/'],
            'middle_name' => ['nullable', 'regex:/^\s*[a-zA-Z]+(\s+[a-zA-Z]+)*\s*$/'],
            'last_name' => ['nullable', 'regex:/^\s*[a-zA-Z]+(\s+[a-zA-Z]+)*\s*$/'],
            'relation_type' => ['required', Rule::enum(MemberRelationshipWithSponsor::class)],
            'eid' => ['required_without_all:unified_number,birth_certificate_number,residence_file_no,passport_number','nullable', 'regex:/^784\d{12}$/'],
            'eid_application_no' => ['nullable'],
            'email' => ['required', 'email'],
            'unified_number' => [
                'required_without_all:birth_certificate_number',
                'nullable',
                'digits_between:5,9',
                Rule::requiredIf(!Carbon::parse($this->date_of_birth)->isNewBorn($this->product->birth_certificate_max_age,$this->product->birth_certificate_max_age_type)),
            ],
            'residence_file_no' => [
                'required_without_all:birth_certificate_number',
                'regex:/^[0-9]{3}\/[0-9]{4}\/[0-9]\/[0-9]{2,10}$/',
                'nullable',
                Rule::requiredIf(!Carbon::parse($this->date_of_birth)->isNewBorn($this->product->birth_certificate_max_age,$this->product->birth_certificate_max_age_type)),
            ],
            'type' => ['required', Rule::enum(MemberType::class)],
            'profession' => ['nullable'],
            'date_of_birth' => ['required', 'date'], // TODO add rules for age
            'gender' => ['required', Rule::enum(MemberGender::class)],
            'nationality' => ['required','string','size:2','exists:countries,code'],
            'marital_status' => ['required', Rule::enum(MemberMaritalStatus::class)],
            'passport_number' => ['required', 'regex:/^[a-zA-Z0-9]*$/'],
            'salary' => ['required', Rule::enum(MemberSalary::class)],
            'height' => ['nullable', 'digits_between:0,400'],
            'weight' => ['nullable', 'digits_between:0,700'],
            'country_id' => ['required',Rule::exists('countries', 'id')->where('id', 235)],
            'residence_location_id' => ['required'],
            'occupation' => ['required'],
            'region_id' => ['required','exists:regions,id'],
            'sub_region_id' => [
                'required',
                'exists:sub_regions,id',
                function ($attribute, $value, $fail) use ($payload) {
                    $subRegion = SubRegion::find($value);
                    if (!$subRegion) {
                        $fail("Unable to find sub region with ID {$value}.");
                    } elseif ($subRegion->region_id != $payload['region_id']) {
                        $fail("The selected sub region (ID: {$value}) does not belong to the selected region (ID: {$payload['region_id']}).");
                    }
                },
            ],
            'birth_certificate_number' => ['required_without_all:unified_number,eid,passport_number','nullable'], // add rules for age
            'quote_id' => ['required'],
            'attachments.profile' => ['nullable','required'],
            'attachments.visa' => ['nullable','required'],
            'attachments.passport' => ['nullable','required'],
            'attachments.eid_front' => ['nullable','required'],
            'attachments.eid_back' => ['nullable'],
            'attachments.other' => ['nullable'],
        ]);
        unset($payload['attachments']);
        return $payload;

    }

    public function getPayloadForUpdate(): array
    {
        if($this->product){
            $age = Carbon::parse($this->date_of_birth)->age;
            try {
                $productPlan = ProductPlan::query()
                    ->where('product_id',$this->product->id)
                    ->forAge($age)
                    ->firstOrFail();
            } catch (\Exception $e) {
                throw new \Exception("Couldn't find suitable product plan for this member, please check the age");
            }
            $this->price = $productPlan?->price ?? 0;
            $this->vat_percentage = $productPlan?->vat_percentage ?? 0;
            $this->price_with_vat = $productPlan?->price_with_vat ?? 0;
            $this->slash_data_fees = $productPlan?->slash_data_fees ?? 0;
            $this->total = $productPlan?->total ?? 0;
        }
        try {
            $residence_location = ResidenceLocation::where('id', $this->residence_location_id)->firstOrFail();
        } catch (\Exception $e) {
            throw new \Exception("Couldn't find residence location with id {$this->region_id}");
        }

        $payload = [
            "first_name" => $this->first_name,
            "middle_name" => $this->middle_name,
            "last_name" => $this->last_name,
            "relation_type" => MemberRelationshipWithSponsor::tryFrom($this->relation_type),
            "eid" => $this->eid,
            "eid_application_no" => $this->eid_application_no,
            "email" => $this->email,
            "unified_number" => $this->unified_number,
            "residence_file_no" => $this->residence_file_no,
            "type" => MemberType::tryFrom($this->type),
            "profession" => $this->profession,
            "date_of_birth" => $this->date_of_birth,
            "gender" => MemberGender::tryFrom($this->gender),
            "nationality" => $this->nationality,
            "marital_status" => MemberMaritalStatus::tryFrom($this->marital_status),
            "passport_number" => $this->passport_number,
            "salary" => MemberSalary::tryFrom($this->salary),
            "height" => $this->height,
            "weight" => $this->weight,
            "price" => $this->price,
            "vat_percentage" => $this->vat_percentage,
            "price_with_vat" => $this->price_with_vat,
            "slash_data_fees" => $this->slash_data_fees,
            "total" => $this->total,
            "country_id" => $this->country_id,
            "residence_location_id" => $residence_location->id,
            "occupation" => $this->occupation,
            "region_id" => $this->region_id,
            "sub_region_id" => $this->sub_region_id,
            "birth_certificate_number" => $this->birth_certificate_number,
        ];

        $this->validate($payload, [
            'first_name' => ['sometimes', 'regex:/^\s*[a-zA-Z]+(\s+[a-zA-Z]+)*\s*$/'],
            'middle_name' => ['nullable', 'regex:/^\s*[a-zA-Z]+(\s+[a-zA-Z]+)*\s*$/'],
            'last_name' => ['nullable', 'regex:/^\s*[a-zA-Z]+(\s+[a-zA-Z]+)*\s*$/'],
            'relation_type' => ['sometimes', Rule::enum(MemberRelationshipWithSponsor::class)],
            'eid' => ['sometimes','nullable', 'regex:/^784\d{12}$/'],
            'eid_application_no' => ['nullable'],
            'email' => ['sometimes', 'email'],
            'unified_number' => [
                'sometimes',
                'nullable',
                'digits_between:5,9',
                Rule::requiredIf(!Carbon::parse($this->date_of_birth)->isNewBorn($this->product->birth_certificate_max_age,$this->product->birth_certificate_max_age_type)),
            ],
            'residence_file_no' => [
                'sometimes',
                'regex:/^[0-9]{3}\/[0-9]{4}\/[0-9]\/[0-9]{2,10}$/',
                'nullable',
                Rule::requiredIf(!Carbon::parse($this->date_of_birth)->isNewBorn($this->product->birth_certificate_max_age,$this->product->birth_certificate_max_age_type)),
            ],
            'type' => ['sometimes', Rule::enum(MemberType::class)],
            'profession' => ['nullable'],
            'date_of_birth' => ['sometimes', 'date'], // TODO add rules for age
            'gender' => ['sometimes', Rule::enum(MemberGender::class)],
            'nationality' => ['sometimes','string','size:2','exists:countries,code'],
            'marital_status' => ['sometimes', Rule::enum(MemberMaritalStatus::class)],
            'passport_number' => ['sometimes', 'regex:/^[a-zA-Z0-9]*$/'],
            'salary' => ['sometimes', Rule::enum(MemberSalary::class)],
            'height' => ['nullable', 'digits_between:0,400'],
            'weight' => ['nullable', 'digits_between:0,700'],
            'country_id' => ['sometimes',Rule::exists('countries', 'id')->where('id', 235)],
            'residence_location_id' => ['sometimes'],
            'occupation' => ['sometimes'],
            'region_id' => ['sometimes','exists:regions,id'],
            'sub_region_id' => [
                'sometimes',
                'exists:sub_regions,id',
                function ($attribute, $value, $fail) use ($payload) {
                    $subRegion = SubRegion::find($value);
                    if (!$subRegion) {
                        $fail("Unable to find sub region with ID {$value}.");
                    } elseif ($subRegion->region_id != $payload['region_id']) {
                        $fail("The selected sub region (ID: {$value}) does not belong to the selected region (ID: {$payload['region_id']}).");
                    }
                },
            ],
            'birth_certificate_number' => ['sometimes','nullable'], // add rules for age
            'attachments.profile' => ['nullable','sometimes'],
            'attachments.visa' => ['nullable','sometimes'],
            'attachments.passport' => ['nullable','sometimes'],
            'attachments.eid_front' => ['nullable','sometimes'],
            'attachments.eid_back' => ['nullable'],
            'attachments.other' => ['nullable'],
        ]);

        return array_filter($payload, function ($value) {
            return $value !== null;
        });
    }

    protected function updateAttachments(Member $member)
    {
        foreach ($this->attachments as $key => $attachment_url) {
            $mappedAttachment = $this->mapAttachement($key);
            if (!empty($mappedAttachment)) {
                MediaApiReceiverHelper::handleUrl(
                    $attachment_url,
                    "member",
                    $member->uid,
                    $mappedAttachment['collection'],
                    $mappedAttachment['type']
                );
            }
        }
    }

    public function create(){
        $createPayload = $this->getPayloadForCreation();

        $member = Member::create($createPayload);
        // create attachments
        if ($member) {
            foreach ($this->attachments as $key => $attachment_url) {
                $collection = $this->mapAttachement($key)['collection'];
                $type = $this->mapAttachement($key)['type'];
                MediaApiReceiverHelper::handleUrl($attachment_url,"Member",$member->uid,$collection,$type);
            }
        }
        return $this;
    }

    public function update(Member $member)
    {
        $updatePayload = $this->getPayloadForUpdate();

        // Update sponsor attributes
        $member->update($updatePayload);

        // Update attachments
        if (isset($this->attachments)) {
            $this->updateAttachments($member);
        }

        return $this;
    }

    public function setQuoteId(int $quoteId){
        $this->quote_id = $quoteId;
    }

    public function setProduct($product_id){
        $product = Product::where('id', $product_id)->firstOrFail();
        $this->product = $product;
    }

    protected function mapAttachement($key){
        return match ($key) {
            'profile' => [
                'collection' => 'profile-picture',
                'type' => 'image',
            ],
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
            'other' => [
                'collection' => 'other-documents',
                'type' => 'document',
            ],
            default => []
        };
    }
}
