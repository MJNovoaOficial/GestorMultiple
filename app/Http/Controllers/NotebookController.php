<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Notebook;
use App\Models\AuditLog;
use App\Models\Brand;
use App\Rules\ValidRut;

class NotebookController extends Controller
{
    public function index(Request $request)
    {
        $query = Notebook::query();

        if($request -> filled('search')){
            
            $terms = explode('', $request->search);

            $query ->where(function ($q) use ($terms){
                
                foreach ($terms as $term){

                    $q->where(function ($sub) use ($term){
                        
                        $sub->where('user_name', 'like', "%{$term}%")
                            ->orWhere('user_rut', 'like', "%{$term}%")
                            ->orWhere('model', 'like', "%{$term}%")
                            ->orWhere('serial_number', 'like', "%{$term}%")
                            ->orWhere('status', 'like', "%{$term}%")
                            ->orWhere('condition', 'like', "%{$term}%")
                            ->orWhere('company_name', 'like', "%{$term}%")
                            //Este es para buscar por marca asociada
                            ->orWhereHas('brand', function ($brandQuery) use ($term) {

                                $brandQuery->where(
                                    'name',
                                    'like',
                                    "%{$term}%"
                                );
                            });
                    });
                }
            });
        }

        $notebooks = $query
            ->with('brand')
            ->latest()
            ->paginate(25)
            ->withQueryString();

        return view('notebooks.index',compact(
            'notebooks'
            ));
    }

    public function create()
    {
        $brands = Brand::orderBy('name')
            ->get();

        return view(
            'notebooks.create',
            compact('brands')
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([

            'user_name' => 'required|string|max:255',

            'model' => 'required|string|max:255',
            
            'delivery_date' => 'required|date',

            'serial_number' => 'required|string|max:255',
            
            'user_rut' => [
                'required',
                'string',
                'max:255',
                new ValidRut
            ],

            'condition' => [
                'required', 'in:available,assigned,retired',
            ],

            'status' =>[
                'required', 'in:new,refurbished'
            ],

            'brand_id' => [
                'required',
                'exists:brands,id',
            ]
        ], [

            //aquí van los mensajes de required
            '*.required' => 'Este campo es obligatorio.',

        ]);

        //Aquí validamos el rut
        if (!empty($validated['user_rut'])){

            $rut = preg_replace('/[^0-9kK]/', $validated['user_rut']);

            $body = substr($rut, 0, -1);

            $dv = strtoupper(substr($rut, -1));

            $validated['user_rut'] = $body . '-' . $dv;
        }

        // Crear Notebook

        $notebook = Notebook::create($validated);

        //Rellena la tabla de auditoria
        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'create',
            'description' => 'Creó un nuevo notebook para el usuario: ' . $notebook->user_name,
            'ip_address' => $request->ip(),
        ]);
        
        return redirect()
            ->route('notebooks.index')
            ->with('success', 'Registro creado correctamente.');
    }

    public function update (Request $request, Notebook $notebook)
    {
        $validated = $request->validate([

            'user_name' => 'required|string|max:255',

            'model' => 'required|string|max:255',
            
            'delivery_date' => 'required|date',

            'serial_number' => 'required|string|max:255',
            
            'user_rut' => [
                'required',
                'string',
                'max:255',
                new ValidRut
            ],

            'condition' => [
                'required', 'in:available,assigned,retired',
            ],

            'status' =>[
                'required', 'in:new,refurbished'
            ],

            'brand_id' => [
                'required',
                'exists:brands,id',
            ]


        ],[
            '*.required' => 'Este campo es obligatorio.',

            'email.email' =>
                'Ingrese un correo válido.',

            'delivery_date.date' =>
                'Ingrese una fecha válida.',
        ]);

        // Validar Rut user
        if (!empty($validated['user_rut'])){

            $rut = preg_replace(
                '/[^0-9kK]/', '' , $validated['user_rut']
            );

            $body = substr($rut, 0, -1);

            $dv = strtoupper(substr($rut,-1));
            $validated['user_rut'] = $body . '-' . $dv;
        }

        $notebook->update($validated);

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'update',
            'description' =>
                'Actualizó notebook corporativo: '
                .
        ]);

    }

}