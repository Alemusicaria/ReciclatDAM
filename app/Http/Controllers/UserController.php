<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Rol;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use App\Models\Activity;
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    private function canManageUser(User $user): bool
    {
        $authUser = Auth::user();

        if (!$authUser) {
            return false;
        }

        return (int) $authUser->rol_id === 1 || (int) $authUser->id === (int) $user->id;
    }

    public function index()
    {
        $authUser = Auth::user();
        $users = ((int) $authUser->rol_id === 1)
            ? User::with('rol')->get()
            : User::with('rol')->where('id', $authUser->id)->get();
        if (!view()->exists('users.index')) {
            return redirect()->route('dashboard')->with('info', 'La vista pública d\'usuaris no està disponible.');
        }
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $rols = Rol::all();
        if (!view()->exists('users.create')) {
            return redirect()->route('dashboard')->with('info', 'La vista de creació d\'usuaris no està disponible.');
        }
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
            if (Auth::check()) {
                Activity::create([
                    'user_id' => Auth::id(),
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
            Log::error('Error al crear l\'usuari: ' . $e->getMessage());

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No s\'ha pogut crear l\'usuari.'
                ], 422);
            }

            return back()->withErrors(['error' => 'No s\'ha pogut crear l\'usuari.']);
        }
    }

    public function show(User $user)
    {
        if (!$this->canManageUser($user)) {
            abort(403, 'No tens permisos per veure aquest perfil.');
        }

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
        if (!$this->canManageUser($user)) {
            abort(403, 'No tens permisos per editar aquest perfil.');
        }

        $rols = Rol::all();
        return view('users.edit', compact('user', 'rols'));
    }

    public function update(Request $request, User $user)
    {
        // Check authorization first, before try/catch, so it's not swallowed
        if (!$this->canManageUser($user)) {
            abort(403, 'No tens permisos per actualitzar aquest perfil.');
        }

        try {
            $isAdmin = (int) Auth::user()->rol_id === 1;

            $request->validate([
                'nom' => 'required|string|max:255',
                'cognoms' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
                'data_naixement' => 'nullable|date',
                'telefon' => 'nullable|string|max:15',
                'ubicacio' => 'nullable|string|max:255',
                'rol_id' => $isAdmin ? 'required|exists:rols,id' : 'prohibited',
                'punts_actuals' => $isAdmin ? 'nullable|integer|min:0' : 'prohibited',
                'foto_perfil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB
                'password' => 'nullable|string|min:8|confirmed',
            ]);

            // Determinar si és una sol·licitud AJAX
            $isAjax = $request->ajax() || $request->wantsJson();

            // Actualitzar dades bàsiques de l'usuari
            $allowedFields = [
                'nom',
                'cognoms',
                'email',
                'data_naixement',
                'telefon',
                'ubicacio',
            ];

            if ($isAdmin) {
                $allowedFields[] = 'rol_id';
                $allowedFields[] = 'punts_actuals';
            }

            $userData = $request->only($allowedFields);

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
                    Log::error('Error al guardar foto de perfil', [
                        'user_id' => $user->id,
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString()
                    ]);

                    if ($isAjax) {
                        return response()->json([
                            'success' => false,
                            'message' => 'No s\'ha pogut actualitzar la foto de perfil.'
                        ], 500);
                    }
                    // Per a sol·licituds no AJAX, continuem amb una advertència
                    session()->flash('warning', 'S\'ha actualitzat l\'usuari però hi ha hagut un problema amb la foto de perfil.');
                }
            }

            // Registrar activitat
            if (Auth::check()) {
                Activity::create([
                    'user_id' => Auth::id(),
                    'action' => 'Ha actualitzat el perfil de ' . $user->nom . ' ' . $user->cognoms
                ]);
            }

            // Per a sol·licituds AJAX (com la del modal)
            if ($isAjax) {
                // Preparar la ruta de la foto per a la resposta AJAX
                $photoPath = null;
                if ($user->foto_perfil) {
                    if (str_starts_with($user->foto_perfil, 'https://')) {
                        $photoPath = $user->foto_perfil;
                    } else {
                        $photoPath = Storage::url($user->foto_perfil);
                    }
                }
                
                return response()->json([
                    'success' => true,
                    'message' => 'Usuari actualitzat correctament',
                    'path' => $photoPath,
                    'user' => $user
                ]);
            }

            // Per a sol·licituds normals
            return redirect()->route('users.show', $user->id)
                ->with('success', 'Usuari actualitzat correctament');
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            Log::error('Error al actualitzar usuari', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al actualitzar l\'usuari.'
                ], 500);
            }

            return back()->withErrors(['error' => 'Error al actualitzar l\'usuari.']);
        }
    }

    public function updatePhoto(Request $request, User $user)
    {
        if (!$this->canManageUser($user)) {
            abort(403, 'No tens permisos per actualitzar la foto d\'aquest perfil.');
        }

        $validated = $request->validate([
            'foto_perfil' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        try {
            if ($user->foto_perfil && !str_starts_with($user->foto_perfil, 'https://')) {
                if (Storage::disk('public')->exists($user->foto_perfil)) {
                    Storage::disk('public')->delete($user->foto_perfil);
                }
            }

            $path = $request->file('foto_perfil')->store('profile_photos', 'public');

            if (!$path || !Storage::disk('public')->exists($path)) {
                throw new \Exception('No s\'ha pogut guardar la foto de perfil.');
            }

            $user->foto_perfil = $path;
            $user->save();

            if (Auth::check()) {
                Activity::create([
                    'user_id' => Auth::id(),
                    'action' => 'Ha actualitzat la foto de perfil de ' . $user->nom . ' ' . $user->cognoms,
                ]);
            }

            $response = [
                'success' => true,
                'path' => asset('storage/' . $path),
                'message' => 'Foto de perfil actualitzada correctament',
            ];

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json($response);
            }

            return back()->with('success', $response['message']);
        } catch (\Exception $e) {
            Log::error('Error al actualitzar la foto de perfil', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
            ]);

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al actualitzar la foto.',
                ], 500);
            }

            return back()->withErrors(['error' => 'Error al actualitzar la foto.']);
        }
    }

    public function destroy(User $user)
    {
        try {
            if ((int) Auth::user()->rol_id !== 1) {
                abort(403, 'No tens permisos per eliminar usuaris.');
            }

            $userName = $user->nom . ' ' . $user->cognoms; // Guardar el nom abans d'eliminar

            // Eliminar foto de perfil si existeix i no és una URL externa
            if ($user->foto_perfil && !str_starts_with($user->foto_perfil, 'https://')) {
                if (Storage::disk('public')->exists($user->foto_perfil)) {
                    Storage::disk('public')->delete($user->foto_perfil);
                }
            }

            $user->delete();

            // Registrar activitat
            if (Auth::check()) {
                Activity::create([
                    'user_id' => Auth::id(),
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
            Log::error('Error al eliminar usuari: ' . $e->getMessage());

            if (request()->expectsJson() || request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al eliminar l\'usuari.'
                ], 500);
            }

            return back()->withErrors(['error' => 'Error al eliminar l\'usuari.']);
        }
    }
}