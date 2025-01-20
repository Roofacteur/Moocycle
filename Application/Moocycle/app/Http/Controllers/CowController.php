<?php

namespace App\Http\Controllers;

use App\Models\Cow;
use App\Models\Race; // Importer le modèle Race
use Illuminate\Http\Request;

class CowController extends Controller
{
    // Méthode pour supprimer une vache
    public function destroy($num_tblVache)
    {
        // Trouver la vache avec l'identifiant unique (num_tblVache)
        $cow = Cow::findOrFail($num_tblVache);

        // Supprimer la vache
        $cow->delete();

        // Rediriger avec un message de succès
        return redirect()->route('cows.index')->with('success', 'Vache supprimée avec succès.');
    }
    // Méthode pour afficher le formulaire de modification d'une vache
    public function edit($id)
    {
        $cow = Cow::findOrFail($id); // Trouver la vache avec l'ID
        $races = Race::all(); // Récupérer toutes les races
        $currentRace = $cow->races->first(); // Récupérer la première race associée à la vache (si une race est associée)
        
        return view('cows.editcows', compact('cow', 'races', 'currentRace')); // Passer les données à la vue
    }
    public function update(Request $request, $num_tblVache)
    {
        // Validation des données
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'numero_collier' => 'required|string|max:50',
            'numero_oreille' => 'required|string|max:50',
            'date_naissance' => 'required|date',
            'num_tblRace' => 'required|exists:tbl_races,num_tblRace',
        ]);

        // Trouver la vache par son identifiant
        $cow = Cow::where('num_tblVache', $num_tblVache)->firstOrFail();

        // Mise à jour de la vache
        $cow->update($validated);

        // Synchroniser la race
        $cow->races()->sync([$request->input('num_tblRace')]);

        // Redirection vers la liste des vaches (route 'cows.index')
        return redirect()->route('cows.index')->with('success', 'Vache mise à jour avec succès !');
    }
    public function index()
    {
        $cows = Cow::all(); // Récupère toutes les vaches
        return view('cows.cows', compact('cows')); // Retourne la vue avec le bon chemin
    }

}
