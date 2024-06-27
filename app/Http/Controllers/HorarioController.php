<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Horario;
use Validator;
use Auth;

class HorarioController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $empresa = $user->empresa; // Asumiendo que hay una relación uno a uno entre usuario y empresa
        $horarios = $empresa->horarios; // Obtener los horarios de la empresa

        return view('empresa.horarios', compact('horarios'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'dia' => 'required|string',
            'abre_a' => 'nullable|date_format:H:i',
            'cierra_a' => 'nullable|date_format:H:i',
            'cerrada' => 'boolean',
        ]);

        $data['user_id'] = Auth::user()->id; // Asignar el ID del usuario

        Horario::create($data);

        return redirect()->back()->with('success', 'Horario guardado correctamente.');
    }
}