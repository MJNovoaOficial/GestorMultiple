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
            'Visualizó la contraseña de:' . $password->email
        );

        return response()->json([
            'password' => $password->password
        ]);
    }
}