<?php

namespace App\Domain\DTOs;

use Livewire\Wireable;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Database\Eloquent\Castable;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class ICPConfiguration implements Castable, Wireable
{

    public function __construct(public string $driver, public array $config = [])
    {
    }

    public function toArray(): array
    {
        return ['driver' => $this->driver, 'config' => $this->config];
    }

    public function config($key, $default = null)
    {
        $data = data_get($this->config, $key, $default);
        return $this->castUsing([])->isEncrypted($data) ? Crypt::decrypt($data) : $data;
    }

    public static function castUsing(array $arguments)
    {
        return new class implements CastsAttributes
        {
            public function get(Model $model, string $key, mixed $value, array $attributes): ?ICPConfiguration
            {
                return rescue(function () use ($value) {
                    $object = json_decode($value, true);

                    return new ICPConfiguration(
                        $object['driver'],
                        array_map(function($value){
                            return Crypt::encrypt($value);
                        }, $object['config'] ?? [])
                    );
                });
            }

            public function set(Model $model, string $key, mixed $value, array $attributes): ?string
            {
                if ($value = (object) $value){
                    $value->config = array_map(function ($config) {
                        return $this->isEncrypted($config) ? Crypt::decrypt($config) : $config;
                    }, $value->config ?? []);
                    return json_encode($value);
                }
                return  null;
            }

            public function isEncrypted($string)
            {
                try {
                    Crypt::decrypt($string);
                    return true;
                } catch (DecryptException $e) {
                    return false;
                } catch (\Exception $e) {
                    return false;
                }
            }
        };
    }

    public function toLivewire()
    {
        return $this->toArray();
    }

    public static function fromLivewire($value)
    {
        return new static($value['driver'], $value['config']);
    }
}
