<?php
namespace App\Http\Controllers;

use App\Models\Session;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    public function index()
    {
        $sessions = Session::all();
        if (!view()->exists('sessions.index')) {
            return redirect()->route('dashboard')->with('info', 'La vista de sessions no està disponible.');
        }
        return view('sessions.index', compact('sessions'));
    }

    public function create()
    {
        if (!view()->exists('sessions.create')) {
            return redirect()->route('dashboard')->with('info', 'La vista de creació de sessions no està disponible.');
        }
        return view('sessions.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'ip_address' => 'nullable',
            'user_agent' => 'nullable',
            'payload' => 'required',
            'last_activity' => 'required|integer',
        ]);

        Session::create($validated);
        return redirect()->route('sessions.index');
    }

    public function show(Session $session)
    {
        if (!view()->exists('sessions.show')) {
            return redirect()->route('dashboard')->with('info', 'La vista de detall de sessions no està disponible.');
        }
        return view('sessions.show', compact('session'));
    }

    public function edit(Session $session)
    {
        if (!view()->exists('sessions.edit')) {
            return redirect()->route('dashboard')->with('info', 'La vista d\'edició de sessions no està disponible.');
        }
        return view('sessions.edit', compact('session'));
    }

    public function update(Request $request, Session $session)
    {
        $validated = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'ip_address' => 'nullable',
            'user_agent' => 'nullable',
            'payload' => 'required',
            'last_activity' => 'required|integer',
        ]);

        $session->update($validated);
        return redirect()->route('sessions.index');
    }

    public function destroy(Session $session)
    {
        $session->delete();
        return redirect()->route('sessions.index');
    }
}