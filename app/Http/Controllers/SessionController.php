<?php
namespace App\Http\Controllers;

use App\Models\Session;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    public function index()
    {
        $sessions = Session::all();
        return view('sessions.index', compact('sessions'));
    }

    public function create()
    {
        return view('sessions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'ip_address' => 'nullable',
            'user_agent' => 'nullable',
            'payload' => 'required',
            'last_activity' => 'required|integer',
        ]);

        Session::create($request->all());
        return redirect()->route('sessions.index');
    }

    public function show(Session $session)
    {
        return view('sessions.show', compact('session'));
    }

    public function edit(Session $session)
    {
        return view('sessions.edit', compact('session'));
    }

    public function update(Request $request, Session $session)
    {
        $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'ip_address' => 'nullable',
            'user_agent' => 'nullable',
            'payload' => 'required',
            'last_activity' => 'required|integer',
        ]);

        $session->update($request->all());
        return redirect()->route('sessions.index');
    }

    public function destroy(Session $session)
    {
        $session->delete();
        return redirect()->route('sessions.index');
    }
}