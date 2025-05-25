<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Rol;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Activity;
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('rol')->get();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $rols = Rol::all();
        return view('users.create', compact('rols'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nom' => 'required|string|max:255',
                'cognoms' => 'required|string|max:255',
                'data_naixement' => 'nullable|date',
                'telefon' => 'nullable|string|max:15',
                'ubicacio' => 'nullable|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8',
                'rol_id' => 'required|exists:rols,id',
                'punts_actuals' => 'nullable|integer',
                'foto_perfil' => 'nullable|image|max:2048',
            ]);

            $user = new User();
            $user->nom = $validated['nom'];
            $user->cognoms = $validated['cognoms'];
            $user->email = $validated['email'];
            $user->password = Hash::make($validated['password']);
            $user->rol_id = $validated['rol_id'];
            $user->punts_actuals = $validated['punts_actuals'] ?? 0;
            $user->punts_totals = $validated['punts_actuals'] ?? 0;
            $user->punts_gastats = 0;

            // Assignar els camps opcionals
            $user->data_naixement = $validated['data_naixement'] ?? null;
            $user->telefon = $validated['telefon'] ?? null;
            $user->ubicacio = $validated['ubicacio'] ?? null;

            if ($request->hasFile('foto_perfil')) {
                $path = $request->file('foto_perfil')->store('profile_photos', 'public');
                $user->foto_perfil = $path;
            }

            $user->save();

            // Enviar correo de bienvenida
            if ($user->email) {
                Mail::to($user->email)->send(new WelcomeMail($user));
            }
            
            // Registrar activitat
            if (auth()->check()) {
                Activity::create([
                    'user_id' => auth()->id(),
                    'action' => 'Ha creat un nou usuari: ' . $user->nom . ' ' . $user->cognoms
                ]);
            }

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Usuari creat correctament',
                    'user' => $user
                ]);
            }

            return redirect()->route('admin.dashboard')->with('success', 'Usuari creat correctament');
        } catch (\Exception $e) {
            \Log::error('Error al crear l\'usuari: ' . $e->getMessage());

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al crear l\'usuari: ' . $e->getMessage()
                ], 422);
            }

            return back()->withErrors(['error' => 'Error al crear l\'usuari: ' . $e->getMessage()]);
        }
    }

    public function show(User $user)
    {
        // Carregar els esdeveniments de l'usuari amb la relació pivot i dades relacionades
        $user->load([
            'events' => function ($query) {
                $query->with('tipus');  // Carregar el tipus d'esdeveniment per mostrar colors, etc.
            }
        ]);

        // Carregar els premis reclamats
        $user->load('premisReclamats.premi');

        // Aquí carreguem els productes associats als registres d'esdeveniments de l'usuari
        $eventUserIds = $user->events->pluck('pivot.producte_id')->filter()->unique();
        if ($eventUserIds->count() > 0) {
            $productes = \App\Models\Producte::whereIn('id', $eventUserIds)->get()->keyBy('id');
            $user->productes = $productes;
        }

        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $rols = Rol::all();
        return view('users.edit', compact('user', 'rols'));
    }

    public function update(Request $request, User $user)
    {
        try {
            $request->validate([
                'nom' => 'required|string|max:255',
                'cognoms' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
                'data_naixement' => 'nullable|date',
                'telefon' => 'nullable|string|max:15',
                'ubicacio' => 'nullable|string|max:255',
                'rol_id' => 'required|exists:rols,id',
                'punts_actuals' => 'nullable|integer|min:0',
                'foto_perfil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB
                'password' => 'nullable|min:8',
            ]);

            // Determinar si és una sol·licitud AJAX
            $isAjax = $request->ajax() || $request->wantsJson();

            // Actualitzar dades bàsiques de l'usuari
            $userData = $request->only([
                'nom',
                'cognoms',
                'email',
                'data_naixement',
                'telefon',
                'ubicacio',
                'rol_id',
                'punts_actuals'
            ]);

            // Si s'ha proporcionat una nova contrasenya, actualitzar-la
            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }

            // Actualitzar els camps de l'usuari
            $user->update($userData);

            // Processar la foto de perfil si es proporciona
            if ($request->hasFile('foto_perfil')) {
                try {
                    // Esborrar la foto anterior si existeix i no és una URL externa
                    if ($user->foto_perfil && !str_starts_with($user->foto_perfil, 'https://')) {
                        if (Storage::disk('public')->exists($user->foto_perfil)) {
                            Storage::disk('public')->delete($user->foto_perfil);
                        }
                    }

                    // Guardar la nova foto
                    $path = $request->file('foto_perfil')->store('profile_photos', 'public');

                    // Verificar que l'arxiu s'ha guardat correctament
                    if (!$path || !Storage::disk('public')->exists($path)) {
                        throw new \Exception('No s\'ha pogut guardar l\'arxiu a l\'emmagatzematge.');
                    }

                    $user->foto_perfil = $path;
                    $user->save();
                } catch (\Exception $e) {
                    \Log::error('Error al guardar foto de perfil', [
                        'user_id' => $user->id,
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString()
                    ]);

                    if ($isAjax) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Error en actualitzar la foto: ' . $e->getMessage()
                        ], 500);
                    }
                    // Per a sol·licituds no AJAX, continuem amb una advertència
                    session()->flash('warning', 'S\'ha actualitzat l\'usuari però hi ha hagut un problema amb la foto: ' . $e->getMessage());
                }
            }

            // Registrar activitat
            if (auth()->check()) {
                Activity::create([
                    'user_id' => auth()->id(),
                    'action' => 'Ha actualitzat el perfil de ' . $user->nom . ' ' . $user->cognoms
                ]);
            }

            // Per a sol·licituds AJAX (com la del modal)
            if ($isAjax) {
                return response()->json([
                    'success' => true,
                    'message' => 'Usuari actualitzat correctament',
                    'user' => $user
                ]);
            }

            // Per a sol·licituds normals
            return redirect()->route('admin.users.show', $user->id)
                ->with('success', 'Usuari actualitzat correctament');
        } catch (\Exception $e) {
            \Log::error('Error al actualitzar usuari', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al actualitzar l\'usuari: ' . $e->getMessage()
                ], 500);
            }

            return back()->withErrors(['error' => 'Error al actualitzar l\'usuari: ' . $e->getMessage()]);
        }
    }

    public function destroy(User $user)
    {
        try {
            $userName = $user->nom . ' ' . $user->cognoms; // Guardar el nom abans d'eliminar

            // Eliminar foto de perfil si existeix i no és una URL externa
            if ($user->foto_perfil && !str_starts_with($user->foto_perfil, 'https://')) {
                if (Storage::disk('public')->exists($user->foto_perfil)) {
                    Storage::disk('public')->delete($user->foto_perfil);
                }
            }

            $user->delete();

            // Registrar activitat
            if (auth()->check()) {
                Activity::create([
                    'user_id' => auth()->id(),
                    'action' => 'Ha eliminat l\'usuari ' . $userName
                ]);
            }

            if (request()->expectsJson() || request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Usuari eliminat correctament'
                ]);
            }

            return redirect()->route('admin.dashboard')->with('success', 'Usuari eliminat correctament');
        } catch (\Exception $e) {
            \Log::error('Error al eliminar usuari: ' . $e->getMessage());

            if (request()->expectsJson() || request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al eliminar l\'usuari: ' . $e->getMessage()
                ], 500);
            }

            return back()->withErrors(['error' => 'Error al eliminar l\'usuari: ' . $e->getMessage()]);
        }
    }
}