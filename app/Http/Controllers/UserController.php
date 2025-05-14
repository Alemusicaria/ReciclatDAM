<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Rol;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        $request->validate([
            'nom' => 'required|string|max:255',
            'cognoms' => 'required|string|max:255',
            'data_naixement' => 'nullable|date',
            'telefon' => 'nullable|string|max:15',
            'ubicacio' => 'nullable|string',
            'punts_totals' => 'nullable|integer',
            'punts_actuals' => 'nullable|integer',
            'punts_gastats' => 'nullable|integer',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'rol_id' => 'nullable|integer|exists:rols,id',
            'foto_perfil' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $user = new User($request->all());
        if ($request->hasFile('foto_perfil')) {
            $path = $request->file('foto_perfil')->store('profile_photos', 'public');
            $user->foto_perfil = $path;
        }
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('users.index');
    }

    public function show(User $user)
    {
        // Cargar los eventos del usuario con la relación pivot y datos relacionados
        $user->load([
            'events' => function ($query) {
                $query->with('tipus');  // Cargar el tipo de evento para mostrar colores, etc.
            }
        ]);

        // Cargar los premios reclamados
        $user->load('premisReclamats.premi');

        // Aquí cargamos los productos asociados a los registros de eventos del usuario
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
                'nom' => 'nullable|string|max:255',
                'cognoms' => 'nullable|string|max:255',
                'email' => 'nullable|string|email|max:255|unique:users,email,' . $user->id,
                'data_naixement' => 'nullable|date',
                'telefon' => 'nullable|string|max:15',
                'ubicacio' => 'nullable|string|max:255',
                'foto_perfil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120', // Aumentado a 5MB
            ]);

            // Si la solicitud solo contiene foto_perfil, es una actualización de foto vía AJAX
            if ($request->hasFile('foto_perfil')) {
                // Registrar información para depuración
                \Log::info('Actualizando foto de perfil', [
                    'user_id' => $user->id,
                    'original_filename' => $request->file('foto_perfil')->getClientOriginalName(),
                    'size' => $request->file('foto_perfil')->getSize(),
                    'mime' => $request->file('foto_perfil')->getMimeType()
                ]);

                try {
                    // Borrar la foto anterior si existe y no es una URL externa
                    if ($user->foto_perfil && !str_starts_with($user->foto_perfil, 'https://')) {
                        if (Storage::disk('public')->exists($user->foto_perfil)) {
                            Storage::disk('public')->delete($user->foto_perfil);
                        }
                    }

                    // Guardar la nueva foto
                    $path = $request->file('foto_perfil')->store('profile_photos', 'public');

                    // Verificar que el archivo se guardó correctamente
                    if (!$path || !Storage::disk('public')->exists($path)) {
                        throw new \Exception('No se pudo guardar el archivo en el almacenamiento.');
                    }

                    $user->foto_perfil = $path;
                    $user->save();

                    // Respuesta JSON para peticiones AJAX
                    return response()->json([
                        'success' => true,
                        'message' => 'Foto de perfil actualitzada correctament',
                        'path' => Storage::url($path)
                    ]);
                } catch (\Exception $e) {
                    // Registrar el error
                    \Log::error('Error al guardar foto de perfil', [
                        'user_id' => $user->id,
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString()
                    ]);

                    // Respuesta de error en JSON
                    return response()->json([
                        'success' => false,
                        'message' => 'Error al actualitzar la foto: ' . $e->getMessage()
                    ], 500);
                }
            }

            // Para actualizaciones normales del formulario completo
            $user->update($request->only(['nom', 'cognoms', 'email', 'data_naixement', 'telefon', 'ubicacio']));

            if ($request->hasFile('foto_perfil')) {
                // Borrar la foto anterior si existe y no es una URL externa
                if ($user->foto_perfil && !str_starts_with($user->foto_perfil, 'https://')) {
                    Storage::disk('public')->delete($user->foto_perfil);
                }

                // Guardar la nueva foto
                $path = $request->file('foto_perfil')->store('profile_photos', 'public');
                $user->foto_perfil = $path;
                $user->save();
            }

            return redirect()->route('users.show', $user->id)->with('success', 'Perfil actualitzat correctament.');

        } catch (\Exception $e) {
            // Registrar el error
            \Log::error('Error en actualización de usuario', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error: ' . $e->getMessage()
                ], 500);
            }

            return back()->withErrors(['error' => 'Error al actualizar el perfil: ' . $e->getMessage()]);
        }
    }

    public function destroy(User $user)
    {
        if ($user->foto_perfil) {
            Storage::disk('public')->delete($user->foto_perfil);
        }
        $user->delete();
        return redirect()->route('users.index');
    }
}