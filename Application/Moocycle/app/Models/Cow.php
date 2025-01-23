<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cow extends Model
{
    use HasFactory;

    protected $table = 'tbl_vaches';

    protected $primaryKey = 'num_tblVache';

    public $timestamps = false; 

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
    public function logs()
    {
        return $this->hasMany(Log::class, 'num_tblVache', 'num_tblVache');
    }
}
