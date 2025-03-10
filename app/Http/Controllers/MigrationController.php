<?php
namespace App\Http\Controllers;

use App\Models\Migration;
use Illuminate\Http\Request;

class MigrationController extends Controller
{
    public function index()
    {
        $migrations = Migration::all();
        return view('migrations.index', compact('migrations'));
    }

    public function create()
    {
        return view('migrations.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'migration' => 'required|unique:migrations',
            'batch' => 'required|integer',
        ]);

        Migration::create($request->all());
        return redirect()->route('migrations.index');
    }

    public function show(Migration $migration)
    {
        return view('migrations.show', compact('migration'));
    }

    public function edit(Migration $migration)
    {
        return view('migrations.edit', compact('migration'));
    }

    public function update(Request $request, Migration $migration)
    {
        $request->validate([
            'migration' => 'required|unique:migrations,migration,' . $migration->id,
            'batch' => 'required|integer',
        ]);

        $migration->update($request->all());
        return redirect()->route('migrations.index');
    }

    public function destroy(Migration $migration)
    {
        $migration->delete();
        return redirect()->route('migrations.index');
    }
}