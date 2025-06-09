<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pertanyaan extends Model
{

    protected $fillable = ['pertanyaan', 'kriteria_id', 'urutan'];
   public function kriteria()
    {
        return $this->belongsTo(Kriteria::class);
    }

    public function jawabanUser()
{
    return $this->hasMany(\App\Models\JawabanUser::class, 'pertanyaan_id');
}

}



