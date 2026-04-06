<?php
namespace App\Http\Controllers;

use App\Models\Migration;
use Illuminate\Http\Request;

class MigrationController extends Controller
{
    public function index()
    {
        $migrations = Migration::all();
        if (!view()->exists('migrations.index')) {
            return redirect()->route('dashboard')->with('info', 'La vista de migrations no està disponible.');
        }
        return view('migrations.index', compact('migrations'));
    }

    public function create()
    {
        if (!view()->exists('migrations.create')) {
            return redirect()->route('dashboard')->with('info', 'La vista de creació de migrations no està disponible.');
        }
        return view('migrations.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'migration' => 'required|unique:migrations',
            'batch' => 'required|integer',
        ]);

        Migration::create($validated);
        return redirect()->route('migrations.index');
    }

    public function show(Migration $migration)
    {
        if (!view()->exists('migrations.show')) {
            return redirect()->route('dashboard')->with('info', 'La vista de detall de migrations no està disponible.');
        }
        return view('migrations.show', compact('migration'));
    }

    public function edit(Migration $migration)
    {
        if (!view()->exists('migrations.edit')) {
            return redirect()->route('dashboard')->with('info', 'La vista d\'edició de migrations no està disponible.');
        }
        return view('migrations.edit', compact('migration'));
    }

    public function update(Request $request, Migration $migration)
    {
        $validated = $request->validate([
            'migration' => 'required|unique:migrations,migration,' . $migration->id,
            'batch' => 'required|integer',
        ]);

        $migration->update($validated);
        return redirect()->route('migrations.index');
    }

    public function destroy(Migration $migration)
    {
        $migration->delete();
        return redirect()->route('migrations.index');
    }
}