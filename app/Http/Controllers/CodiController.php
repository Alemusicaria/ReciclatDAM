<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Codi;
use App\Models\Activity;
use Carbon\Carbon;

class CodiController extends Controller
{
    /**
     * Procesa un código escaneado y asigna puntos
     */
    public function processCode(Request $request)
    {
        try {
            $code = $request->input('code');
            $user = auth()->user();
            
            // Verificar si el usuario ha escaneado este código recientemente (últimos 5 minutos)
            $ultimoEscaneo = Codi::where('codi', $code)
                                 ->where('user_id', $user->id)
                                 ->where('data_escaneig', '>=', Carbon::now()->subMinutes(5))
                                 ->first();
                                     
            if ($ultimoEscaneo) {
                return response()->json([
                    'success' => false,
                    'message' => 'Has d\'esperar 5 minuts abans de tornar a escanejar aquest codi'
                ]);
            }

            // Calcular puntos según el código (puedes modificar esta lógica)
            $puntos = $this->calcularPuntos($code);
            
            // Guardar el nuevo escaneo
            $codi = new Codi();
            $codi->codi = $code;
            $codi->user_id = $user->id;
            $codi->punts = $puntos;
            $codi->data_escaneig = now();
            $codi->save();
            
            // Actualizar puntos del usuario
            $user->punts_actuals += $puntos;
            $user->punts_totals += $puntos;
            $user->save();
            
            // Registrar actividad
            Activity::create([
                'user_id' => $user->id,
                'action' => 'Ha escanejat el codi ' . $code . ' i ha guanyat ' . $puntos . ' punts'
            ]);
            
            return response()->json([
                'success' => true,
                'points' => $puntos,
                'new_total' => $user->punts_actuals,
                'message' => 'Has guanyat ' . $puntos . ' ECODAMS'
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Error procesando código', [
                'code' => $request->input('code'), 
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error intern: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Calcula los puntos basados en el código de barras
     * Puedes implementar aquí tu propia lógica de puntuación
     */
    private function calcularPuntos($code)
    {
        // Ejemplo: asignar puntos basados en la longitud o algún algoritmo
        // En este caso simple, damos entre 10 y 20 puntos
        return rand(10, 20);
        
        // Alternativa: usar los últimos dígitos del código como puntos
        // return min(50, max(5, intval(substr($code, -2))));
    }
}