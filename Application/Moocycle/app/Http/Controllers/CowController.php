<?php

namespace App\Http\Controllers;

use App\Models\Cow;
use App\Models\Race;
use App\Models\Logs;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CowController extends Controller
{
    public function index()
    {
        $cows = Cow::all(); // Remplace "Cow" par le bon modèle si besoin
        return view('health', compact('cows'));
    }

    // Méthode pour supprimer une vache
    public function destroy($id)
    {
        $cow = Cow::findOrFail($id);
        $cow->races()->detach();
        $cow->delete();

        return redirect()->route('cows.get')->with('success', 'Vache supprimée avec succès.');
    }

    // Méthode pour afficher le formulaire de modification d'une vache
    public function edit($num_tblVache) // Utiliser num_tblVache au lieu de $id
    {
        $cow = Cow::findOrFail($num_tblVache); // Trouver la vache avec son ID
        $races = Race::all(); // Récupérer toutes les races disponibles
        $currentRace = $cow->races->first(); // Récupérer la race actuelle (si disponible)

        return view('cows.editcows', compact('cow', 'races', 'currentRace')); // Passer les données à la vue
    }


    // Méthode pour mettre à jour une vache
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'numero_collier' => 'required|string|max:50',
            'numero_oreille' => 'required|string|max:50',
            'date_naissance' => 'required|date',
            'num_tblRace' => 'required|exists:tbl_races,num_tblRace',
        ]);

        $cow = Cow::findOrFail($id);
        $cow->update($request->only(['nom', 'numero_collier', 'numero_oreille']));
        $cow->races()->sync([$request->input('num_tblRace')]);

        return redirect()->route('cows.get')->with('success', 'Vache mise à jour avec succès.');
    }

    // Méthode pour récupérer les vaches avec un filtre ou non
    public function get(Request $request)
    {
        $races = Race::all();
        
        $cowsQuery = Cow::with('races'); // Charger la relation races
    
        // Appliquer le filtre si une race est sélectionnée
        if ($request->has('race') && $request->race != '') {
            $cowsQuery->whereHas('races', function ($query) use ($request) {
                $query->where('num_tblRace', $request->race);
            });
        }
    
        $cows = $cowsQuery->get(); // Récupérer les vaches après le filtrage
    
        return view('cows.cows', compact('cows', 'races'));
    }
    
    public function show($id)
    {
        $cow = Cow::with(['logs' => function ($query) {
            $query->orderBy('date', 'asc');
        }])->findOrFail($id);

        $dates = $cow->logs->where('insemination', false)->pluck('date');

        // Si moins de deux dates, retourner 20 jours par défaut
        if (count($dates) < 2) {
            $average = 21.0 *-1;
        } else {
            $intervals = [];
            for ($i = 1; $i < count($dates); $i++) {
                $intervals[] = Carbon::parse($dates[$i])->diffInDays(Carbon::parse($dates[$i - 1]));
            }

            // Calculer la moyenne
            $average = array_sum($intervals) / count($intervals);
        }

        $currentRace = $cow->races->first(); // Récupérer la première race associée

        return view('cows.readcows', [
            'cow' => $cow,
            'currentRace' => $currentRace,
            'average' => round($average *-1, 2) // Arrondi à 2 décimales
        ]);
    }

    public function incrementLactation($id)
    {
        // Trouver la vache par son ID
        $cow = Cow::findOrFail($id);

        // Incrémenter le nombre de lactations
        $cow->increment('nombre_lactation');

        // Retourner une réponse JSON
        return response()->json(['success' => true]);
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
    public function average($idVache)
    {
        // Récupérer les logs de la vache triés par date
        $cow = Cow::with(['logs' => function ($query) {
            $query->orderBy('date', 'asc');
        }])->findOrFail($idVache);

        // Récupérer toutes les dates de chaleurs, excluant celles où l'insémination a été effectuée
        $dates = $cow->logs->where('insemination', false)->pluck('date');

        // Si moins de deux dates, retourner 20 jours par défaut
        if (count($dates) < 2) {
            $average = 21.0;
        } else {
            $intervals = [];
            for ($i = 1; $i < count($dates); $i++) {
                $intervals[] = Carbon::parse($dates[$i])->diffInDays(Carbon::parse($dates[$i - 1]));
            }

            // Calculer la moyenne des intervalles
            $average = array_sum($intervals) / count($intervals);
        }

        // Ajouter la moyenne à la dernière date de chaleur pour obtenir la prochaine chaleur
        $lastHeatDate = Carbon::parse($dates->last());
        $nextHeatDate = $lastHeatDate->addDays($average);

        // Mettre à jour les dates dans le modèle
        $cow->date_derniere_chaleur = $lastHeatDate->format('Y-m-d');
        $cow->date_prochaine_chaleur = $nextHeatDate->format('Y-m-d');
        $cow->save();

        return view('cows.readcows', [
            'cow' => $cow, 
            'average' => round($average, 2), // Arrondi à 2 décimales
            'nextHeatDate' => $nextHeatDate->format('Y-m-d') // Format de la date de la prochaine chaleur
        ]);
    }

    public function calendar()
    {
        $cows = Cow::with(['logs' => function ($query) {
            $query->orderBy('date', 'desc');
        }])->get();

        return view('layouts.calendar', compact('cows'));
    }
    public function health(Request $request)
    {
        $races = Race::all();
        
        $cowsQuery = Cow::with('races'); // Charger la relation races
    
        // Appliquer le filtre si une race est sélectionnée
        if ($request->has('race') && $request->race != '') {
            $cowsQuery->whereHas('races', function ($query) use ($request) {
                $query->where('num_tblRace', $request->race);
            });
        }
    
        $cows = $cowsQuery->get(); // Récupérer les vaches après le filtrage
    
        return view('layouts.health', compact('cows', 'races'));
    }

}
