<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HasilRekomendasi extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'negara_id', 'skor'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function negara()
    {
        return $this->belongsTo(Negara::class);
    }
}

