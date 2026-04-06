<?php
namespace App\Http\Controllers;

use App\Models\CacheLock;
use Illuminate\Http\Request;

class CacheLockController extends Controller
{
    public function index()
    {
        $cacheLocks = CacheLock::all();
        if (!view()->exists('cache-locks.index')) {
            return redirect()->route('dashboard')->with('info', 'La vista de cache-locks no està disponible.');
        }
        return view('cache-locks.index', compact('cacheLocks'));
    }

    public function create()
    {
        if (!view()->exists('cache-locks.create')) {
            return redirect()->route('dashboard')->with('info', 'La vista de creació de cache-locks no està disponible.');
        }
        return view('cache-locks.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'key' => 'required|unique:cache_locks',
            'owner' => 'required',
            'expiration' => 'required|integer',
        ]);

        CacheLock::create($validated);
        return redirect()->route('cache-locks.index');
    }

    public function show(CacheLock $cacheLock)
    {
        if (!view()->exists('cache-locks.show')) {
            return redirect()->route('dashboard')->with('info', 'La vista de detall de cache-locks no està disponible.');
        }
        return view('cache-locks.show', compact('cacheLock'));
    }

    public function edit(CacheLock $cacheLock)
    {
        if (!view()->exists('cache-locks.edit')) {
            return redirect()->route('dashboard')->with('info', 'La vista d\'edició de cache-locks no està disponible.');
        }
        return view('cache-locks.edit', compact('cacheLock'));
    }

    public function update(Request $request, CacheLock $cacheLock)
    {
        $validated = $request->validate([
            'owner' => 'required',
            'expiration' => 'required|integer',
        ]);

        $cacheLock->update($validated);
        return redirect()->route('cache-locks.index');
    }

    public function destroy(CacheLock $cacheLock)
    {
        $cacheLock->delete();
        return redirect()->route('cache-locks.index');
    }
}