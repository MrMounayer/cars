<?php

namespace App\Domain\DTOs;

use Illuminate\Contracts\Database\Eloquent\Castable;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class BackupServerConfiguration implements Castable
{
    public function __construct() {}

    public static function castUsing(array $arguments)
    {
        return new class implements CastsAttributes
        {
            public function get(Model $model, string $key, mixed $value, array $attributes): array
            {
                return rescue(function () use ($value) {
                    $config = json_decode($value, true);
                    $config = array_map(function ($value) {
                        return Crypt::encrypt($value);
                    }, $config ?? []);

                    return $config;
                });
            }

            public function set(Model $model, string $key, mixed $value, array $attributes): ?string
            {
                if ($value) {
                    return json_encode(array_map(function ($config) {
                        return $this->isEncrypted($config) ? Crypt::decrypt($config) : $config;
                    }, $value ?? []));
                }

                return null;
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
}
