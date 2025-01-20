<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cow extends Model
{
    use HasFactory;

    // Indique que la table associée à ce modèle est 'tbl_vaches'
    protected $table = 'tbl_vaches';

    // Si tu veux spécifier une clé primaire différente (par défaut, c'est 'id')
    protected $primaryKey = 'num_tblVache';

    // Si la clé primaire n'est pas un entier auto-incrémenté, définis-le ici
    // public $incrementing = false; // Si jamais la clé n'est pas auto-incrémentée

    // Spécifie si les timestamps sont gérés (les colonnes created_at et updated_at)
    public $timestamps = false; // Car il n'y a pas de colonnes 'created_at' et 'updated_at'

    // Liste des attributs modifiables
    protected $fillable = [
        'nom',
        'numero_collier',
        'numero_oreille',
        'date_prochaine_chaleur',
        'date_insemination',
        'date_naissance',
        'nombre_lactation',
    ];

    // Si tu veux ajouter des dates à l'attribut $dates (par exemple, pour le formatage)
    protected $dates = [
        'date_prochaine_chaleur',
        'date_insemination',
        'date_naissance',
    ];
    public function races()
    {
        return $this->belongsToMany(Race::class, 'tbl_raceVache', 'num_tblVache', 'num_tblRace');
    }
}
