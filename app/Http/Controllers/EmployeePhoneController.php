<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\EmployeePhonesImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\EmployeePhone;
use App\Models\AuditLog;
use App\Rules\ValidRut;

class EmployeePhoneController extends Controller
{
    public function index(Request $request)
    {
        $query = EmployeePhone::query();

        /*
        |--------------------------------------------------------------------------
        | Búsqueda
        |--------------------------------------------------------------------------
        */
        if ($request->filled('search')) {

            $terms = explode(' ', $request->search);

            $query->where(function ($q) use ($terms) {

                foreach ($terms as $term) {

                    $q->where(function ($sub) use ($term) {

                        $sub->where('phone_number', 'like', "%{$term}%")
                            ->orWhere('first_name', 'like', "%{$term}%")
                            ->orWhere('last_name', 'like', "%{$term}%")
                            ->orWhere('phone_model', 'like', "%{$term}%")
                            ->orWhere('imei', 'like', "%{$term}%")
                            ->orWhere('position', 'like', "%{$term}%")
                            ->orWhere('department', 'like', "%{$term}%")
                            ->orWhere('vendor_code', 'like', "%{$term}%")
                            ->orWhere('company_name', 'like', "%{$term}%")
                            ->orWhere('rut', 'like', "%{$term}%")
                            ->orWhere('email', 'like', "%{$term}%");

                    });

                }

            });

        }

        $activeCount = EmployeePhone::where('status', 'active')->count();

        $returnedCount = EmployeePhone::where('status', 'returned')->count();

        $blockedCount = EmployeePhone::where('status', 'blocked')->count();

        $totalCount = EmployeePhone::count();

        $devices = $query
            ->latest()
            ->paginate(25)
            ->withQueryString();

        return view('employee-phones.index', compact(
            'devices',
            'activeCount',
            'returnedCount',
            'blockedCount',
            'totalCount'
        ));
    }
 
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        $import = new EmployeePhonesImport();

        //Excel::import($import, $request->file('file'));

        dd(
            $file->getPathname(),
            file_exists($file->getPathname()),
            is_readable($file->getPathname())
        );

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'import',
            'description' => 'Importó celulares corporativos desde Excel.',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()
            ->back()
            ->with('success',

                "Importación finalizada. "

                . "Importados: {$import->imported}. "

                . "Ignorados: {$import->skipped}. "

                . "Duplicados: {$import->duplicates}."
            );
    }

    public function create()
    {
        return view('employee-phones.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([

            'phone_number' => [
                'required',
                'regex:/^9\d{8}$/'
            ],

            'first_name' => 'required|string|max:255',

            'last_name' => 'required|string|max:255',

            'phone_model' => 'required|string|max:255',

            'delivery_date' => 'required|date',

            'imei' => 'required|string|max:255',

            'position' => 'required|string|max:255',

            'department' => 'required|string|max:255',

            'vendor_code' => 'required|string|max:255',

            'company_name' => 'required|string|max:255',

            'rut' => [
                'required',
                'string',
                'max:255',
                new ValidRut
            ],

            'email' => 'required|email|max:255',

            'observations' => 'nullable|string',

        ], [

            // REQUIRED

            '*.required' => 'Este campo es obligatorio.',

            // CUSTOM

            'phone_number.regex' =>
                'El número debe contener exactamente 9 dígitos y comenzar con 9.',

            'email.email' =>
                'Ingrese un correo válido.',

        ]);

        // Estado automático
        $validated['status'] = 'active';

        //valida el número de teléfono
        $request->validate([
            'phone_number' => [
                'required',
                'regex:/^9\d{8}$/'
            ],
        ], [
            'phone_number.regex' => 'El número debe contener exactamente 9 dígitos y comenzar con 9.',
        ]);
        
        //valida el rut       
        if (!empty($validated['rut'])) {

            $rut = preg_replace('/[^0-9kK]/', '', $validated['rut']);

            $body = substr($rut, 0, -1);

            $dv = strtoupper(substr($rut, -1));

            $validated['rut'] = number_format($body, 0, '', '.') . '-' . $dv;
        }

        // Crear dispositivo
        $device = EmployeePhone::create($validated);

        // AUDIT LOG
        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'create',
            'description' => 'Creó un nuevo celular corporativo: ' . $device->phone_number,
            'ip_address' => $request->ip(),
        ]);

        return redirect()
            ->route('employee-phones.index')
            ->with('success', 'Registro creado correctamente.');
    }

    public function update(Request $request, EmployeePhone $employeePhone)
    {
        $validated = $request->validate([

            'phone_number' => [
                'required',
                'regex:/^9\d{8}$/'
            ],

            'first_name' => 'required|string|max:255',

            'last_name' => 'required|string|max:255',

            'phone_model' => 'required|string|max:255',
            
            'delivery_date' => 'required|date',

            'imei' => 'required|string|max:255',

            'position' => 'required|string|max:255',

            'department' => 'required|string|max:255',

            'vendor_code' => 'required|string|max:255',

            'company_name' => 'required|string|max:255',

            'rut' => [
                'required',
                'string',
                'max:255',
                new ValidRut
            ],

            'email' => 'required|email|max:255',

            'status' => 'required|in:active,returned,blocked',

            'observations' => 'nullable|string',

        ], [

            '*.required' => 'Este campo es obligatorio.',

            'phone_number.regex' =>
                'El número debe contener exactamente 9 dígitos y comenzar con 9.',

            'email.email' =>
                'Ingrese un correo válido.',
            
            'delivery_date.date' =>
                'Ingrese una fecha válida.',

        ]);

        // Normalizar teléfono
        $validated['phone_number'] =
            '+56' . $validated['phone_number'];

        // Normalizar RUT
        if (!empty($validated['rut'])) {

            $rut = preg_replace(
                '/[^0-9kK]/',
                '',
                $validated['rut']
            );

            $body = substr($rut, 0, -1);

            $dv = strtoupper(substr($rut, -1));
            $validated['rut'] = number_format($body, 0, '', '.') . '-' . $dv;
        }

        $employeePhone->update($validated);

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'update',
            'description' =>
                'Actualizó celular corporativo: '
                . $employeePhone->phone_number,
            'ip_address' => $request->ip(),
        ]);

        return redirect()
            ->route('employee-phones.index')
            ->with(
                'success',
                'Registro actualizado correctamente.'
            );
    }
}