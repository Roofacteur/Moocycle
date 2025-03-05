<?php

namespace App\Http\Controllers;

use App\Models\Cow;
use App\Models\Race;
use App\Models\Log;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CowController extends Controller
{
    // Vérification de la connexion de l'utilisateur
    public function isConnected()
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        return true;
    }

    public function index()
    {
        $cows = Cow::all();
        return view('health', compact('cows'));
    }

    // Méthode pour supprimer une vache
    public function destroy($id)
    {
        $cow = Cow::findOrFail($id);
        $cow->races()->detach(); // Détacher les races associées avant la suppression
        $cow->delete();

        return redirect()->route('cows.get')->with('success', 'Vache supprimée avec succès.');
    }

    // Méthode pour afficher le formulaire de modification d'une vache
    public function edit($num_tblVache)
    {
        $cow = Cow::findOrFail($num_tblVache); // Trouver la vache avec son ID
        $races = Race::all(); // Récupérer toutes les races disponibles
        $currentRace = $cow->races->first(); // Récupérer la race actuelle

        return view('cows.editcows', compact('cow', 'races', 'currentRace'));
    }

    // Méthode pour mettre à jour une vache
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'numero_collier' => 'required|string|max:50',
            'numero_oreille' => 'required|string|max:50',
            'date_naissance' => 'required|date',
            'num_tblRace' => 'required|exists:tbl_races,num_tblRace',  // Valider la race sélectionnée
        ]);

        $cow = Cow::findOrFail($id);
        $cow->update($request->only(['nom', 'numero_collier', 'numero_oreille']));

        // Associer la race avec la méthode sync pour une relation plusieurs-à-plusieurs
        $cow->races()->sync([$request->input('num_tblRace')]);

        return redirect()->route('cows.get')->with('success', 'Vache mise à jour avec succès.');
    }


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
        
        // Filtrer les vaches par ID de l'utilisateur
        $userId = auth()->user()->id; 
        $cowsQuery->where('num_tblUser', $userId);
        
        $cows = $cowsQuery->get();
        return view('cows.cows', compact('cows', 'races'));
    }
    
    public function show($id)
    {
        // Récupérer la vache avec ses logs triés par date
        $cow = Cow::with(['logs' => function ($query) {
            $query->orderBy('date', 'asc');
        }])->findOrFail($id);

        // Récupérer les dates de chaleurs, excluant celles où l'insémination a été effectuée
        $dates = $cow->logs->where('insemination', false)->pluck('date');
    
        // Si moins de deux dates, retourner 20 jours par défaut
        $average = count($dates) < 2 ? 21.0 : $this->calculateAverageHeatInterval($dates);
    
        // Ajouter la moyenne à la dernière date de chaleur pour obtenir la prochaine chaleur
        $lastHeatDate = Carbon::parse($dates->last());
        $nextHeatDate = $lastHeatDate->copy()->addDays($average);
    
        // Mettre à jour les dates dans le modèle
        $cow->date_prochaine_chaleur = $nextHeatDate->format('Y-m-d');
        $cow->save();
    
        // Récupérer la première race associée à la vache
        $currentRace = $cow->races->first();

        $birth = $cow->date_naissance ? Carbon::parse($cow->date_naissance)->format('d.m.Y') : null;
        $lastHeatDateFormatted = $lastHeatDate ? $lastHeatDate->format('d.m.Y') : null;
        $nextHeatDateFormatted = $nextHeatDate->format('d.m.Y');

        // Retourner la vue avec toutes les informations nécessaires
        return view('cows.readcows', [
            'cow' => $cow, 
            'currentRace' => $currentRace,
            'birth' => $birth,
            'average' => round($average, 0), 
            'lastHeatDate' => $lastHeatDateFormatted,
            'nextHeatDate' => $nextHeatDateFormatted
        ]);
    }

    // Calcul de l'intervalle moyen entre les dates de chaleur
    private function calculateAverageHeatInterval($dates)
    {
        $intervals = [];
        for ($i = 1; $i < count($dates); $i++) {
            $intervals[] = Carbon::parse($dates[$i])->diffInDays(Carbon::parse($dates[$i - 1]));
        }
        return array_sum($intervals) / count($intervals);
    }

    public function addLatestDate($id)
    {
        $log = new Log();
        $log->date = now();
        $log->insemination = false;
        $log->num_tblVache = $id;
        $log->save();
        $this-> show($id);
        return response()->json(['success' => true]);
    }

    public function incrementLactation($id)
    {
        $cow = Cow::findOrFail($id);
        $cow->increment('nombre_lactation');
        return response()->json(['success' => true]);
    }

    // Formulaire d'ajout d'une nouvelle vache
    public function create()
    {
        $races = Race::all();
        
        return view('cows.addcows', compact('races'));
    }

    // Enregistrement d'une nouvelle vache
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'numero_collier' => 'required|string|max:12',
            'numero_oreille' => 'required|string|max:12',
            'date_naissance' => 'required|date|before_or_equal:today',
            'num_tblRace' => 'required|exists:tbl_races,num_tblRace',
        ], [
            'numero_collier.string' => 'Le numéro de collier doit être une chaîne valide.',
            'numero_collier.max' => 'Le numéro de collier ne peut pas dépasser 12 caractères.',
            'numero_oreille.string' => 'Le numéro d\'oreille doit être une chaîne valide.',
            'numero_oreille.max' => 'Le numéro d\'oreille ne peut pas dépasser 12 caractères.',
            'date_naissance.date' => 'La date de naissance doit être une date valide.',
            'date_naissance.before_or_equal' => 'La date de naissance ne peut pas être dans le futur.',
        ]);

        if (Auth::check()) {
            $cow = new Cow($validated);
            $cow->num_tblUser = Auth::id();
            if($cow->nombre_lactation == null){
                $cow->nombre_lactation = 0;
            }
            $cow->save();
    
            // Associer la race (avec la clé étrangère dans la table associative)
            $cow->races()->attach($request->input('num_tblRace'));
        }
    
        return redirect()->route('cows.get')->with('success', 'Vache ajoutée avec succès !');
    }

    // Affichage du calendrier
    public function calendar()
    {
        $cows = Cow::with(['logs' => function ($query) {
            $query->orderBy('date', 'desc');
        }])->get();

        return view('layouts.calendar', compact('cows'));
    }

    // Méthode de santé des vaches
    public function health(Request $request)
    {
        $this->isConnected(); // Vérifier si l'utilisateur est connecté

        $races = Race::all();
        $cowsQuery = Cow::with('races'); // Charger la relation races
        
        // Appliquer le filtre si une race est sélectionnée
        if ($request->has('race') && $request->race != '') {
            $cowsQuery->whereHas('races', function ($query) use ($request) {
                $query->where('num_tblRace', $request->race);
            });
        }
        
        // Filtrer les vaches par ID de l'utilisateur
        $userId = auth()->user()->id; 
        $cowsQuery->where('num_tblUser', $userId);
        $cows = $cowsQuery->get();
        return view('layouts.health', compact('cows', 'races'));
    }
}
