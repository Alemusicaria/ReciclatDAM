<?php
namespace App\Http\Controllers;

use App\Models\Cache;
use Illuminate\Http\Request;

class CacheController extends Controller
{
    public function index()
    {
        $caches = Cache::all();
        return view('caches.index', compact('caches'));
    }

    public function create()
    {
        return view('caches.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'key' => 'required|unique:caches',
            'value' => 'required',
            'expiration' => 'required|integer',
        ]);

        Cache::create($request->all());
        return redirect()->route('caches.index');
    }

    public function show(Cache $cache)
    {
        return view('caches.show', compact('cache'));
    }

    public function edit(Cache $cache)
    {
        return view('caches.edit', compact('cache'));
    }

    public function update(Request $request, Cache $cache)
    {
        $request->validate([
            'value' => 'required',
            'expiration' => 'required|integer',
        ]);

        $cache->update($request->all());
        return redirect()->route('caches.index');
    }

    public function destroy(Cache $cache)
    {
        $cache->delete();
        return redirect()->route('caches.index');
    }
}