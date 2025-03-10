<?php
namespace App\Http\Controllers;

use App\Models\Codi;
use Illuminate\Http\Request;

class CodiController extends Controller
{
    public function index()
    {
        $codis = Codi::all();
        return view('codis.index', compact('codis'));
    }

    public function create()
    {
        return view('codis.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'codi' => 'required|unique:codis',
            'punts' => 'required|integer',
            'data_escaneig' => 'required|date',
        ]);

        Codi::create($request->all());
        return redirect()->route('codis.index');
    }

    public function show(Codi $codi)
    {
        return view('codis.show', compact('codi'));
    }

    public function edit(Codi $codi)
    {
        return view('codis.edit', compact('codi'));
    }

    public function update(Request $request, Codi $codi)
    {
        $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'codi' => 'required|unique:codis,codi,' . $codi->id,
            'punts' => 'required|integer',
            'data_escaneig' => 'required|date',
        ]);

        $codi->update($request->all());
        return redirect()->route('codis.index');
    }

    public function destroy(Codi $codi)
    {
        $codi->delete();
        return redirect()->route('codis.index');
    }
}