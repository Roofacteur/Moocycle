<?php

namespace App\Http\Controllers;

use App\Models\Cow;
use App\Models\Race;
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
        return redirect()->route('cows.get')->with('success', 'Vache supprimée avec succès.');
    }

    // Méthode pour afficher le formulaire de modification d'une vache
    public function edit($id)
    {
        $cow = Cow::findOrFail($id); // Trouver la vache avec l'ID
        $races = Race::all(); // Récupérer toutes les races
        $currentRace = $cow->races->first(); // Récupérer la première race associée à la vache (si une race est associée)
        
        return view('cows.editcows', compact('cow', 'races', 'currentRace')); // Passer les données à la vue
    }

    // Méthode pour mettre à jour une vache
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
        $cow = Cow::findOrFail($num_tblVache);

        // Mise à jour de la vache
        $cow->update($validated);

        // Synchroniser la race
        $cow->races()->sync([$request->input('num_tblRace')]);

        // Redirection vers la liste des vaches (route 'cows.get')
        return redirect()->route('cows.get')->with('success', 'Vache mise à jour avec succès !');
    }

    // Méthode pour récupérer les vaches avec un filtre ou non
    public function get(Request $request)
    {
        $races = Race::all();
        
        $cowsQuery = Cow::query();

        // Appliquer le filtre si une race est sélectionnée
        if ($request->has('race') && $request->race != '') {
            $cowsQuery->whereHas('races', function($query) use ($request) {
                $query->where('id', $request->race);
            });
        }

        $cows = $cowsQuery->get(); // Récupérer les vaches après le filtrage (ou pas)

        return view('cows.cows', compact('cows', 'races'));
    }

    // Méthode pour filtrer (en fait, on réutilise get)
    public function filter(Request $request)
    {
        // Récupérer toutes les races disponibles
        $races = Race::all();
        
        // Créer une requête de base pour les vaches
        $cowsQuery = Cow::query();
        
        // Appliquer le filtre si une race est sélectionnée
        if ($request->has('race') && $request->race != '') {
            $cowsQuery->whereHas('races', function($query) use ($request) {
                $query->where('id', $request->race);
            });
        }

        // Récupérer les vaches après le filtrage
        $cows = $cowsQuery->get();
        
        // Passer les variables à la vue filteredcows
        return view('cows.filteredcows', compact('cows', 'races'));
    }

     
    // Méthode pour afficher le formulaire d'ajout d'une nouvelle vache
    public function create()
    {
        $races = Race::all(); // Récupère toutes les races disponibles
        return view('cows.addcows', compact('races')); // Passe les races à la vue
    }    

    // Méthode pour enregistrer une nouvelle vache dans la base de données
    public function store(Request $request)
    {
        // Validation des données
        $validated = $request->validate([
            'nom' => 'required|string|max:255', // Validation du nom
            'numero_collier' => 'required|string|max:50', // Validation du numéro de collier (doit être une chaîne)
            'numero_oreille' => 'required|string|max:50', // Validation du numéro d'oreille (doit être une chaîne)
            'date_naissance' => 'required|date|before_or_equal:today', // Validation de la date de naissance (doit être une date valide et pas dans le futur)
            'num_tblRace' => 'required|exists:tbl_races,num_tblRace', // Validation de la race (doit exister dans la table des races)
        ], [
            // Personnalisation des messages d'erreur (facultatif)
            'numero_collier.string' => 'Le numéro de collier doit être une chaîne valide.',
            'numero_collier.max' => 'Le numéro de collier ne peut pas dépasser 50 caractères.',
            'numero_oreille.string' => 'Le numéro d\'oreille doit être une chaîne valide.',
            'numero_oreille.max' => 'Le numéro d\'oreille ne peut pas dépasser 50 caractères.',
            'date_naissance.date' => 'La date de naissance doit être une date valide.',
            'date_naissance.before_or_equal' => 'La date de naissance ne peut pas être dans le futur.',
        ]);

        // Créer la nouvelle vache
        $cow = Cow::create($validated);

        // Ajouter la relation avec la race
        $cow->races()->attach($request->input('num_tblRace'));

        // Rediriger vers la liste des vaches avec un message de succès
        return redirect()->route('cows.get')->with('success', 'Vache ajoutée avec succès !');
    }

}
