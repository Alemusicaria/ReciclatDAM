<?php

namespace App\Http\Controllers;

use App\Models\Opinions;
use Illuminate\Http\Request;

class OpinionsController extends Controller
{
    public function index()
    {
        $opinions = Opinions::all();
        return view('opinions.index', compact('opinions'));
    }

    public function create()
    {
        return view('opinions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'autor' => 'required|string|max:255',
            'comentari' => 'required|string',
            'estrelles' => 'required|numeric|min:1|max:5',
        ]);

        Opinions::create($request->all());
        return redirect()->route('opinions.index')->with('success', 'Opinió creada correctament!');
    }

    public function edit(Opinions $opinion)
    {
        return view('opinions.edit', compact('opinion'));
    }

    public function update(Request $request, Opinions $opinio)
    {
        $request->validate([
            'autor' => 'required|string|max:255',
            'comentari' => 'required|string',
            'estrelles' => 'required|numeric|min:1|max:5',
        ]);

        $opinio->update($request->all());
        return redirect()->route('opinions.index')->with('success', 'Opinió actualitzada correctament!');
    }

    public function destroy(Opinions $opinio)
    {
        $opinio->delete();
        return redirect()->route('opinions.index')->with('success', 'Opinió eliminada correctament!');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $opinions = Opinions::search($query)->get();

        return view('opinions.search', compact('opinions', 'query'));
    }
}