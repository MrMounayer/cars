<?php

namespace App\Domain\DTOs;

use Illuminate\Contracts\Database\Eloquent\Castable;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use Livewire\Wireable;

class PolicyECard implements Castable, Wireable
{
    public function __construct(protected string $driver, protected string $number)
    {
    }

    public function getNumber()
    {
        return $this->number;
    }

    public function toArray(): array
    {
        return ['driver' => $this->driver, 'number' => $this->number];
    }

    public static function castUsing(array $arguments)
    {
        return new class implements CastsAttributes {

            public function get(Model $model, string $key, mixed $value, array $attributes): ?PolicyECard
            {
                return rescue(function () use ($value) {
                    $object = json_decode($value, true);

                    return new PolicyECard(
                        $object['driver'],
                        $object['number']
                    );
                }, report: false);
            }

            public function set(Model $model, string $key, mixed $value, array $attributes): ?string
            {
                return $value ? json_encode($value->toArray()) : null;
            }
        };
    }

    public function toLivewire()
    {
        return $this->toArray();
    }

    public static function fromLivewire($value)
    {
        return new static($value['driver'], $value['number']);
    }
}
