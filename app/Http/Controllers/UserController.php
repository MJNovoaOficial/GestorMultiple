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

        $temporaryPassword = 'Inicio.2026';

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

    /**
 * Actualizar usuario
 */
    public function update(Request $request, User $user)
    {
        // Evitar auto modificación peligrosa
        if (auth()->id() === $user->id) {

            return redirect()
                ->route('users.index')
                ->with(
                    'error',
                    'No puedes modificar tu propio usuario.'
                );
        }

        /**
         * Cambiar rol
         */
        if ($request->type === 'role') {

            // Solo superadmin
            if (auth()->user()->role !== 'superadmin') {

                abort(403);
            }

            $request->validate([

                'role' => [
                    'required',
                    'in:admin,superadmin',
                ],

            ]);

            $oldRole = $user->role;

            $user->update([
                'role' => $request->role
            ]);

            AuditService::log(

                $request->is_active
                    ? 'updated'
                    : 'deleted',

                $user,

                $request->is_active
                    ? 'Usuario activado: ' . $user->email
                    : 'Usuario eliminado: ' . $user->email,

                [
                    'is_active' => $oldStatus
                ],

                [
                    'is_active' => $request->is_active
                ]

            );

            return redirect()
                ->route('users.index')
                ->with(
                    'success',
                    'Rol actualizado correctamente.'
                );
        }

        /**
         * Cambiar estado
         */
        if ($request->type === 'status') {

            $request->validate([

                'is_active' => [
                    'required',
                    'boolean',
                ],

            ]);

            $oldStatus = $user->is_active;

            $user->update([
                'is_active' => $request->is_active
            ]);

            AuditService::log(
                'updated',
                $user,
                'Estado actualizado para ' . $user->email,
                [
                    'is_active' => $oldStatus
                ],
                [
                    'is_active' => $request->is_active
                ]
            );

            return redirect()
                ->route('users.index')
                ->with(
                    'success',
                    'Estado actualizado correctamente.'
                );
        }

        return redirect()
            ->route('users.index');
    }
}