<?php
namespace App\Http\Controllers;

use App\Models\Cache;
use Illuminate\Http\Request;

class CacheController extends Controller
{
    public function index()
    {
        $caches = Cache::all();
        if (!view()->exists('caches.index')) {
            return redirect()->route('dashboard')->with('info', 'La vista de caches no està disponible.');
        }
        return view('caches.index', compact('caches'));
    }

    public function create()
    {
        if (!view()->exists('caches.create')) {
            return redirect()->route('dashboard')->with('info', 'La vista de creació de caches no està disponible.');
        }
        return view('caches.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'key' => 'required|unique:caches',
            'value' => 'required',
            'expiration' => 'required|integer',
        ]);

        Cache::create($validated);
        return redirect()->route('caches.index');
    }

    public function show(Cache $cache)
    {
        if (!view()->exists('caches.show')) {
            return redirect()->route('dashboard')->with('info', 'La vista de detall de caches no està disponible.');
        }
        return view('caches.show', compact('cache'));
    }

    public function edit(Cache $cache)
    {
        if (!view()->exists('caches.edit')) {
            return redirect()->route('dashboard')->with('info', 'La vista d\'edició de caches no està disponible.');
        }
        return view('caches.edit', compact('cache'));
    }

    public function update(Request $request, Cache $cache)
    {
        $validated = $request->validate([
            'value' => 'required',
            'expiration' => 'required|integer',
        ]);

        $cache->update($validated);
        return redirect()->route('caches.index');
    }

    public function destroy(Cache $cache)
    {
        $cache->delete();
        return redirect()->route('caches.index');
    }
}