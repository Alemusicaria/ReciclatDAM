<?php

namespace App\Http\Controllers;

use App\Models\Opinions;
use Illuminate\Http\Request;

class OpinionsController extends Controller
{
    public function index()
    {
        $opinions = Opinions::all();

        if (!view()->exists('opinions.index')) {
            return redirect()->route('dashboard')->with('info', 'La vista pública d\'opinions no està disponible.');
        }

        return view('opinions.index', compact('opinions'));
    }

    public function create()
    {
        if (!view()->exists('opinions.create')) {
            return redirect()->route('dashboard')->with('info', 'La vista de creació d\'opinions no està disponible.');
        }

        return view('opinions.create');
    }

    public function show(Opinions $opinion)
    {
        if (!view()->exists('opinions.show')) {
            return redirect()->route('dashboard')->with('info', 'La vista de detall d\'opinions no està disponible.');
        }

        return view('opinions.show', compact('opinion'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'autor' => 'required|string|max:255',
            'comentari' => 'required|string',
            'estrelles' => 'required|numeric|min:1|max:5',
        ]);

        Opinions::create($validated);
        return redirect()->route('opinions.index')->with('success', __('messages.system.opinion_created_success'));
    }

    public function edit(Opinions $opinion)
    {
        if (!view()->exists('opinions.edit')) {
            return redirect()->route('dashboard')->with('info', 'La vista d\'edició d\'opinions no està disponible.');
        }

        return view('opinions.edit', compact('opinion'));
    }

    public function update(Request $request, Opinions $opinio)
    {
        $validated = $request->validate([
            'autor' => 'required|string|max:255',
            'comentari' => 'required|string',
            'estrelles' => 'required|numeric|min:1|max:5',
        ]);

        $opinio->update($validated);
        return redirect()->route('opinions.index')->with('success', __('messages.system.opinion_updated_success'));
    }

    public function destroy(Opinions $opinio)
    {
        $opinio->delete();
        return redirect()->route('opinions.index')->with('success', __('messages.system.opinion_deleted_success'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $opinions = Opinions::search($query)->get();

        if (!view()->exists('opinions.search')) {
            return redirect()->route('dashboard')->with('info', 'La vista de cerca d\'opinions no està disponible.');
        }

        return view('opinions.search', compact('opinions', 'query'));
    }
}