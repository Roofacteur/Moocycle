<?php

namespace App\Http\Controllers;

use App\Models\Cow;
use Illuminate\Http\Request;

class CowController extends Controller
{
    // Méthode pour afficher la liste des vaches
    public function index()
    {
        $cows = Cow::all();
        return view('layouts.cows', compact('cows'));
    }

    // Méthode pour afficher le formulaire de modification d'une vache
    public function edit($id)
    {
        $cow = Cow::findOrFail($id); // Trouver la vache avec l'ID
        return view('layouts.editcows', compact('cow')); // Retourne la vue de modification avec les données de la vache
    }
    public function update(Request $request, $num_tblVache)
    {
        // Valider les données entrantes
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'numero_collier' => 'required|string|max:50',
            'numero_oreille' => 'required|string|max:50',
            'date_naissance' => 'required|date',
        ]);

        // Trouver la vache à modifier
        $cow = Cow::where('num_tblVache', $num_tblVache)->firstOrFail();

        // Mettre à jour les champs
        $cow->update($validated);

        // Rediriger avec un message de succès
        return redirect()->route('cows')->with('success', 'Vache mise à jour avec succès !');
    }

    // Méthode pour supprimer une vache
    public function destroy($num_tblVache)
    {
        $cow = Cow::where('num_tblVache', $num_tblVache)->first(); // Utilise num_tblVache pour trouver la vache

        if ($cow) {
            $cow->delete(); // Supprime la vache
            return redirect()->route('cows')->with('success', 'Vache supprimée avec succès');
        }

        return redirect()->route('cows')->with('error', 'Vache non trouvée');
    }

}



