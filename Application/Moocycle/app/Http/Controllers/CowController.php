<?php

namespace App\Http\Controllers;

use App\Models\Cow;  // Assure-toi que le modèle Cow est importé
use Illuminate\Http\Request;

class CowController extends Controller
{
    public function index()
    {
        // Récupère toutes les vaches depuis la base de données
        $cows = Cow::all();

        // Passe la variable $cows à la vue
        return view('layouts.cows', compact('cows'));
    }
}
