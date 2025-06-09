<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BobotNegara extends Model
{
    
    protected $fillable = [
        'negara_id',
        'kriteria_id',
        'nilai_bobot',
    ];
    public function negara()
    {
        return $this->belongsTo(Negara::class);
    }

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class);
    }

}
