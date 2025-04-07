<?php
namespace App\Http\Controllers;

use App\Models\Premi;
use Illuminate\Http\Request;

class PremiController extends Controller
{
    public function index()
    {
        $premis = Premi::all();
        return view('premis.index', compact('premis'));
    }

    public function create()
    {
        return view('premis.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required',
            'descripcio' => 'required',
            'punts_requerits' => 'required|integer',
        ]);

        Premi::create($request->all());
        return redirect()->route('premis.index');
    }

    public function show(Premi $premi)
    {
        return view('premis.show', compact('premi'));
    }

    public function edit(Premi $premi)
    {
        return view('premis.edit', compact('premi'));
    }

    public function update(Request $request, Premi $premi)
    {
        $request->validate([
            'nom' => 'required',
            'descripcio' => 'required',
            'punts_requerits' => 'required|integer',
        ]);

        $premi->update($request->all());
        return redirect()->route('premis.index');
    }

    public function destroy(Premi $premi)
    {
        $premi->delete();
        return redirect()->route('premis.index');
    }
    public function search(Request $request)
    {
        $query = $request->input('query');
        $premis = Premi::search($query)->get();

        return view('premis.search', compact('premis', 'query'));
    }
}