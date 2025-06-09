<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JawabanUser extends Model
{
    protected $fillable = [
    'user_id',
    'pertanyaan_id',
    'nilai_jawaban',
];

public function pertanyaan()
{
    return $this->belongsTo(\App\Models\Pertanyaan::class);
}

public function user()
{
    return $this->belongsTo(\App\Models\User::class);
}


}
