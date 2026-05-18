<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PasswordGeneratorService;

class PasswordGeneratorController extends Controller
{
    public function generate(
        Request $request,
        PasswordGeneratorService $generator
    ) {

        $length = (int) $request->get('length', 12);

        $password = $generator->generate($length);

        return response()->json([
            'password' => $password,
        ]);
    }
}