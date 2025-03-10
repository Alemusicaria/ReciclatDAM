<?php
namespace App\Http\Controllers;

use App\Models\CacheLock;
use Illuminate\Http\Request;

class CacheLockController extends Controller
{
    public function index()
    {
        $cacheLocks = CacheLock::all();
        return view('cache-locks.index', compact('cacheLocks'));
    }

    public function create()
    {
        return view('cache-locks.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'key' => 'required|unique:cache_locks',
            'owner' => 'required',
            'expiration' => 'required|integer',
        ]);

        CacheLock::create($request->all());
        return redirect()->route('cache-locks.index');
    }

    public function show(CacheLock $cacheLock)
    {
        return view('cache-locks.show', compact('cacheLock'));
    }

    public function edit(CacheLock $cacheLock)
    {
        return view('cache-locks.edit', compact('cacheLock'));
    }

    public function update(Request $request, CacheLock $cacheLock)
    {
        $request->validate([
            'owner' => 'required',
            'expiration' => 'required|integer',
        ]);

        $cacheLock->update($request->all());
        return redirect()->route('cache-locks.index');
    }

    public function destroy(CacheLock $cacheLock)
    {
        $cacheLock->delete();
        return redirect()->route('cache-locks.index');
    }
}