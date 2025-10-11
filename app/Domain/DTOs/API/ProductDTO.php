<?php

namespace App\Domain\DTOs\API;

use App\Models\Product;
use App\Models\ResidenceLocation;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ProductDTO
{
        public $uid;
        public $name;
        public $areaOfCover;
        public $category;
        public $annual_financial_limit_pppy;
        public $code;
        public $policy_sdk_no;
        public $co_insurance_in_patient;
        public $co_insurance_out_patient;
        public $co_insurance_diagnosis;
        public $co_insurance_medicine;
        public $pharmacy_annual_limit;
        public $chronic_disease_coverage_limit;
        public $chronic_disease_co_insurance;
        public $room_type;
        public $special_conditions;
        public $required_medical_application_form;
        public $enable_cache;
        public $require_kyc;
        public $tob;
        public $networkFile;
        public $productPlans;

    public function __construct(protected $data)
    {
        $this->fill($data);
    }

    public function toArray(): array
    {
        return [
            'uid' => $this->uid,
            'name' => $this->name,
            'areaOfCover' => $this->areaOfCover,
            'category' => $this->category,
            'annual_financial_limit_pppy' => $this->annual_financial_limit_pppy,
            'code' => $this->code,
            'policy_sdk_no' => $this->policy_sdk_no,
            'co_insurance_in_patient' => $this->co_insurance_in_patient,
            'co_insurance_out_patient' => $this->co_insurance_out_patient,
            'co_insurance_diagnosis' => $this->co_insurance_diagnosis,
            'co_insurance_medicine' => $this->co_insurance_medicine,
            'pharmacy_annual_limit' => $this->pharmacy_annual_limit,
            'chronic_disease_coverage_limit' => $this->chronic_disease_coverage_limit,
            'chronic_disease_co_insurance' => $this->chronic_disease_co_insurance,
            'room_type' => $this->room_type,
            'special_conditions' => $this->special_conditions,
            'required_medical_application_form' => $this->required_medical_application_form,
            'enable_cache' => $this->enable_cache,
            'require_kyc' => $this->require_kyc,
            'tob' => $this->tob,
            'networkFile' => $this->networkFile,
            'productPlans' => $this->productPlans
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

    public function fill(array $data){
        $tob = $data['tob'] ?? null;
        $networkFile = $data['networkFile'] ?? null;
        $areaOfCover = $data['area_of_cover']?? null;
        $productPlans = $data['productPlans']?? null;


        if (isset($data['uid'])) {
            $product = Product::where('uid',$data['uid'])->first();

            $areaOfCover = ResidenceLocation::whereIn('id', $product->area_of_cover)
                ->get()
                ->map(function ($location) {
                    return [
                        'id' => $location->id,
                        'name' => $location->name,
                    ];
                })
                ->toArray();

            $tob = route('getMedia', ['record' => 'Product', 'uid' => $product->uid, 'media' => 'tob']);
            $networkFile = route('getMedia', ['record' => 'Network', 'uid' => $product->network->uid, 'media' => 'network_attachment']);
            $productPlans = $product->productPlans->map(function ($productPlan) {
                $productPlanDTO = new ProductPlanDTO($productPlan->toArray());
                return $productPlanDTO->toArray();
            });

        }

        $this->uid = $data['uid']?? null;
        $this->name = $data['name']?? null;
        $this->areaOfCover = $areaOfCover;
        $this->category = $data['category']?? null;
        $this->annual_financial_limit_pppy = $data['annual_financial_limit_pppy']?? null;
        $this->code = $data['code']?? null;
        $this->policy_sdk_no = $data['policy_sdk_no']?? null;
        $this->co_insurance_in_patient = $data['co_insurance_in_patient']?? null;
        $this->co_insurance_out_patient = $data['co_insurance_out_patient']?? null;
        $this->co_insurance_diagnosis = $data['co_insurance_diagnosis']?? null;
        $this->co_insurance_medicine = $data['co_insurance_medicine']?? null;
        $this->pharmacy_annual_limit = $data['pharmacy_annual_limit']?? null;
        $this->chronic_disease_coverage_limit = $data['chronic_disease_coverage_limit']?? null;
        $this->chronic_disease_co_insurance = $data['chronic_disease_co_insurance']?? null;
        $this->room_type = $data['room_type']?? null;
        $this->special_conditions = $data['special_conditions']?? null;
        $this->required_medical_application_form = $data['required_medical_application_form']?? null;
        $this->enable_cache = $data['enable_cache']?? null;
        $this->require_kyc = $data['require_kyc']?? null;
        $this->tob = $tob;
        $this->networkFile = $networkFile;
        $this->productPlans = $productPlans;
    }
}
