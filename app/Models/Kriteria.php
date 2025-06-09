<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kriteria extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'is_benefit'];
    protected $casts = [
        'is_benefit' => 'boolean',
    ];
    
    public function pertanyaans()
{
    return $this->hasMany(Pertanyaan::class);
}
}
