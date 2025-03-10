<?php
namespace App\Http\Controllers;

use App\Models\PasswordResetToken;
use Illuminate\Http\Request;

class PasswordResetTokenController extends Controller
{
    public function index()
    {
        $tokens = PasswordResetToken::all();
        return view('password-reset-tokens.index', compact('tokens'));
    }

    public function create()
    {
        return view('password-reset-tokens.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:password_reset_tokens',
            'token' => 'required',
            'created_at' => 'nullable|date',
        ]);

        PasswordResetToken::create($request->all());
        return redirect()->route('password-reset-tokens.index');
    }

    public function show(PasswordResetToken $token)
    {
        return view('password-reset-tokens.show', compact('token'));
    }

    public function edit(PasswordResetToken $token)
    {
        return view('password-reset-tokens.edit', compact('token'));
    }

    public function update(Request $request, PasswordResetToken $token)
    {
        $request->validate([
            'token' => 'required',
            'created_at' => 'nullable|date',
        ]);

        $token->update($request->all());
        return redirect()->route('password-reset-tokens.index');
    }

    public function destroy(PasswordResetToken $token)
    {
        $token->delete();
        return redirect()->route('password-reset-tokens.index');
    }
}