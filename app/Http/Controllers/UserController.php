<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Services\AuditService;

class UserController extends Controller
{
    /**
     * Listado usuarios
     */
    public function index()
    {
        $users = User::where('is_active', true)
            ->latest()
            ->paginate(15);

        return view('users.index', compact('users'));
    }

    /**
     * Crear usuario
     */
    public function store(Request $request)
    {
        $validated = $request->validate([

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'unique:users,email',
            ],

            'role' => [
                'required',
                'in:admin,superadmin',
            ],

        ]);

        $temporaryPassword = 'Temp2026!';

        $user = User::create([

            'name' => $validated['name'],

            'email' => $validated['email'],

            'password' => Hash::make($temporaryPassword),

            'role' => $validated['role'],

            'is_active' => true,

            'must_change_password' => true,

        ]);

        AuditService::log(
            'created',
            $user,
            'Usuario creado: ' . $user->email
        );

        return redirect()
            ->route('users.index')
            ->with(
                'success',
                'Usuario creado correctamente. Password temporal: '
                . $temporaryPassword
            );
    }

    /**
     * Deshabilitar usuario
     */
    public function destroy(User $user)
    {
        // Evitar auto eliminación
        if (auth()->id() === $user->id) {

            return redirect()
                ->route('users.index')
                ->with(
                    'error',
                    'No puedes deshabilitar tu propio usuario.'
                );
        }

        // Solo superadmin
        if (auth()->user()->role !== 'superadmin') {

            abort(403);
        }

        $user->update([
            'is_active' => false
        ]);

        AuditService::log(
            'deleted',
            $user,
            'Usuario deshabilitado: ' . $user->email
        );

        return redirect()
            ->route('users.index')
            ->with(
                'success',
                'Usuario deshabilitado correctamente.'
            );
    }
}