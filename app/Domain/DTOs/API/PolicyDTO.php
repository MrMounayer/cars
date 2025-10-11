<?php

namespace App\Domain\DTOs\API;

use App\Models\Policy;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class PolicyDTO
{
    private $uid;
    private $policy_index;
    private $policy_number;
    private $start_at;
    private $expire_at;
    private $cancelled_at;
    private $created_at;
    private $updated_at;

    public function __construct(protected $data)
    {
        $this->fill($data);
    }

    public function toArray(): array
    {
        return [
            'uid' => $this->uid,            
            'policy_index' => $this->policy_index,
            'policy_number' => $this->policy_number,
            'start_at' => $this->start_at,
            'expire_at' => $this->expire_at,
            'cancelled_at' => $this->cancelled_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    public function fill(array $data){
        $this->uid = $data['uid'] ?? null;
        $this->policy_index = $data['policy_index'] ?? null;
        $this->policy_number = $data['policy_number'] ?? null;
        $this->start_at = $data['start_at'] ?? null;
        $this->expire_at = $data['expire_at'] ?? null;
        $this->cancelled_at = $data['cancelled_at'] ?? null;
        $this->created_at = $data['created_at'] ?? null;
        $this->updated_at = $data['updated_at'] ?? null;
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
}
