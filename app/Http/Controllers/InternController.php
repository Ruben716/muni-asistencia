<?php

namespace App\Http\Controllers;

use App\Models\Intern;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InternController extends Controller
{
    /**
     * Muestra la lista de practicantes.
     */
    public function index()
    {
        $interns = Intern::all();
        return view('admin.interns.index', compact('interns'));
    }

    /**
     * Muestra el formulario para registrar un nuevo practicante.
     */
    public function create()
    {
        return view('admin.interns.create');
    }

    /**
     * Guarda un nuevo practicante en la base de datos.
     */
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

    // Ya no intentamos asignar user_id
    $intern = Intern::create($validated);

    if ($intern) {
        return redirect()->route('interns.index')->with('success', 'Practicante registrado correctamente');
    } else {
        return back()->with('error', 'Error al registrar el practicante');
    }
}

    /**
     * Muestra los detalles de un practicante.
     */
    public function show(Intern $intern)
    {
        return view('admin.interns.show', compact('intern'));
    }

    /**
     * Muestra el formulario de edición de un practicante.
     */
    public function edit(Intern $intern)
    {
        return view('admin.interns.edit', compact('intern'));
    }

    /**
     * Actualiza la información del practicante en la base de datos.
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

    $intern->save(); // 💾 Guardar manualmente

    return redirect()->route('interns.index')->with('success', 'Practicante actualizado');
}


    /**
     * Elimina un practicante de la base de datos.
     */
    public function destroy(Intern $intern)
    {
        $intern->delete();
        return redirect()->route('interns.index')->with('success', 'Practicante eliminado correctamente.');
    }
}
