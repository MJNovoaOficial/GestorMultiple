<?php

namespace App\Http\Controllers;

use App\Models\EmailCredential;
use Illuminate\Http\Request;
use App\Services\AuditService;

class PasswordRevealController extends Controller
{
    public function reveal(EmailCredential $password)
    {
        AuditService::log(
            'revealed',
            $password,
            'Visualizó la contraseña de: ' . $password->email
        );

        try {

            return response()->json([
                'password' => decrypt($password->password)
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'password' => 'Error al desencriptar'
            ], 500);

        }
    }
}