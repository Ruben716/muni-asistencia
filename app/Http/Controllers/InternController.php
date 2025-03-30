<?php

namespace App\Http\Controllers;

use App\Models\Intern;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class InternController extends Controller
{
    /**
     * para que no se recargue la pagia sera de utilzar ela funcion de ajax 
     * 
     */
    public function index(Request $request)
{
    $query = Intern::query();

    // Si hay un parámetro 'dni' en la solicitud, filtramos los resultados por el DNI.
    if ($dni = $request->get('dni')) {
        $query->where('dni', 'like', "%$dni%");
    }

    // Obtener los resultados filtrados y luego
    $interns = $query->get();

    // Si la solicitud es AJAX, retornamos los resultados como JSON
    if ($request->wantsJson()) {
        return response()->json(['interns' => $interns]);
    }

    // En caso contrario, mostramos la vista con paginación  
    $interns = $query->paginate(15);

    return view('admin.interns.index', compact('interns'));
}
    /**
     *
     */
    public function create()
    {
        return view('admin.interns.create');
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'lastname' => 'required|string|max:255',
        'dni' => 'required|string|size:8|unique:interns,dni',
        'phone' => 'nullable|string|size:9',
        'arrival_time' => 'required|date_format:H:i',
        'departure_time' => 'required|date_format:H:i|after:arrival_time',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after:start_date',
        'institution' => 'nullable|string|max:255',
    ]);

    $intern = Intern::create($validated);

    if ($intern) {
        // Crear el usuario automáticamente
        $email = $request->dni . '@gmail.com';
        $password = $request->dni; // Guardamos la contraseña para mostrarla en la alerta

        $user = User::create([
            'name' => $request->name . ' ' . $request->lastname,
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        // Asignar el rol 'user'
        $user->assignRole('user');

        // Guardar los datos en la sesión para mostrarlos en la vista
        return redirect()->route('interns.index')->with([
            'success' => 'Practicante registrado correctamente.',
            'email' => $email,
            'password' => $password
        ]);
    } else {
        return back()->with('error', 'Error al registrar el practicante.');
    }
}


    
    //public function show(Intern $intern)
   // {
        //return view('admin.interns.show', compact('intern'));
    //}
    //se modifico el show
    public function show(Intern $intern)
    {
        return response()->json($intern); // Devuelve los datos del practicante como JSON
    }

    /**
     */
    public function edit(Intern $intern)
    {
        return view('admin.interns.edit', compact('intern'));
    }

    /**
     */
    public function update(Request $request, Intern $intern)
{
    $intern->name = $request->name;
    $intern->lastname = $request->lastname;
    $intern->dni = $request->dni;
    $intern->phone = $request->phone;
    $intern->arrival_time = $request->arrival_time;
    $intern->departure_time = $request->departure_time;
    $intern->start_date = $request->start_date;
    $intern->end_date = $request->end_date;
    $intern->institution = $request->institution;

    $intern->save(); 

    return redirect()->route('interns.index')->with('success', 'Practicante actualizado');
}
    /**
     */
    public function destroy(Intern $intern)
    {
        $intern->delete();
        return redirect()->route('interns.index')->with('success', 'Practicante eliminado correctamente.');
    }
}
