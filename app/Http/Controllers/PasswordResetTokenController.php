<?php
namespace App\Http\Controllers;

use App\Models\PasswordResetToken;
use Illuminate\Http\Request;

class PasswordResetTokenController extends Controller
{
    public function index()
    {
        $tokens = PasswordResetToken::all();
        if (!view()->exists('password-reset-tokens.index')) {
            return redirect()->route('dashboard')->with('info', 'La vista de password-reset-tokens no està disponible.');
        }
        return view('password-reset-tokens.index', compact('tokens'));
    }

    public function create()
    {
        if (!view()->exists('password-reset-tokens.create')) {
            return redirect()->route('dashboard')->with('info', 'La vista de creació de password-reset-tokens no està disponible.');
        }
        return view('password-reset-tokens.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|exists:users,email|unique:password_reset_tokens',
            'token' => 'required|string|min:40',
            'created_at' => 'nullable|date',
        ]);

        PasswordResetToken::create($validated);
        return redirect()->route('password-reset-tokens.index')
            ->with('success', 'Password reset token creado correctamente.');
    }

    public function show(PasswordResetToken $token)
    {
        if (!view()->exists('password-reset-tokens.show')) {
            return redirect()->route('dashboard')->with('info', 'La vista de detall de password-reset-tokens no està disponible.');
        }
        return view('password-reset-tokens.show', compact('token'));
    }

    public function edit(PasswordResetToken $token)
    {
        if (!view()->exists('password-reset-tokens.edit')) {
            return redirect()->route('dashboard')->with('info', 'La vista d\'edició de password-reset-tokens no està disponible.');
        }
        return view('password-reset-tokens.edit', compact('token'));
    }

    public function update(Request $request, PasswordResetToken $token)
    {
        $validated = $request->validate([
            'token' => 'required',
            'created_at' => 'nullable|date',
        ]);

        $token->update($validated);
        return redirect()->route('password-reset-tokens.index');
    }

    public function destroy(PasswordResetToken $token)
    {
        $token->delete();
        return redirect()->route('password-reset-tokens.index');
    }
}