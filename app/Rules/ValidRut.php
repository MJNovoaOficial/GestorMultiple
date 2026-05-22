<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidRut implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Limpiar formato
        $rut = preg_replace('/[^kK0-9]/', '', $value);

        if (strlen($rut) < 2) {
            $fail('El RUT ingresado no es válido.');
            return;
        }

        $dv = strtoupper(substr($rut, -1));
        $number = substr($rut, 0, -1);

        $factor = 2;
        $sum = 0;

        for ($i = strlen($number) - 1; $i >= 0; $i--) {

            $sum += $number[$i] * $factor;

            $factor = $factor == 7 ? 2 : $factor + 1;
        }

        $expectedDv = 11 - ($sum % 11);

        $expectedDv = match ($expectedDv) {
            11 => '0',
            10 => 'K',
            default => (string) $expectedDv,
        };

        if ($dv !== $expectedDv) {
            $fail('El RUT ingresado no es válido.');
        }
    }
}