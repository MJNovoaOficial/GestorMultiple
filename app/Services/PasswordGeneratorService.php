<?php

namespace App\Services;

class PasswordGeneratorService
{
    public function generate(int $length = 16): string
    {
        // Limitar longitud
        $length = max(12, min(20, $length));

        $lowercase = 'abcdefghijklmnopqrstuvwxyz';
        $uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $numbers = '0123456789';
        $symbols = '!@#$%^&*()_-+=<>?';

        // Garantizar al menos uno de cada tipo
        $password = [
            $lowercase[random_int(0, strlen($lowercase) - 1)],
            $uppercase[random_int(0, strlen($uppercase) - 1)],
            $numbers[random_int(0, strlen($numbers) - 1)],
            $symbols[random_int(0, strlen($symbols) - 1)],
        ];

        // Todos los caracteres disponibles
        $allCharacters = $lowercase . $uppercase . $numbers . $symbols;

        // Completar longitud restante
        while (count($password) < $length) {
            $password[] = $allCharacters[random_int(0, strlen($allCharacters) - 1)];
        }

        // Mezclar para evitar patrones
        shuffle($password);

        return implode('', $password);
    }
}