<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    protected $table = 'tbl_logs'; // Nom de la table
    protected $primaryKey = 'num_tblLog'; // Clé primaire

    public function vache()
    {
        return $this->belongsTo(Vache::class, 'num_tblVache', 'num_tblVache');
    }
}