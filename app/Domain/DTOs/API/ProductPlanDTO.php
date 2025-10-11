<?php

namespace App\Domain\DTOs\API;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ProductPlanDTO
{
    public $name;
    public $min_client_age;
    public $max_client_age;
    public $total;

    public function __construct(protected $data)
    {
        $this->fill($data);
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'min_client_age' => $this->min_client_age,
            'max_client_age' => $this->max_client_age,
            'total' => $this->total,
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
        $this->name = $data['name']?? null;
        $this->min_client_age = $data['min_client_age']?? null;
        $this->max_client_age = $data['max_client_age']?? null;
        $this->total = $data['total']?? null;
    }
}
