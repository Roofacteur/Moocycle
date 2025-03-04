<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Race extends Model
{
    use HasFactory;

    protected $table = 'tbl_races';
    // Si tu veux spécifier une clé primaire différente (par défaut, c'est 'id')
    protected $primaryKey = 'num_tblRace';
    public $timestamps = false;
    protected $fillable = ['nom'];

    // Définir une relation avec le modèle Cow (si nécessaire)
    public function cows()
    {
        return $this->belongsToMany(Cow::class, 'tbl_raceVache', 'num_tblRace', 'num_tblVache');
    }
}
