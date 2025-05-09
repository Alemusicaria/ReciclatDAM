<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TipusEvent;

class TipusEventController extends Controller
{
    /**
     * Buscar tipos de eventos con Algolia
     */
    public function search(Request $request)
    {
        $query = $request->input('query');
        
        $results = TipusEvent::search($query)->get();
        
        return response()->json($results);
    }
}