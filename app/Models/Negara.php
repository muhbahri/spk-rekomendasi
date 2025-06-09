<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Negara extends Model
{
    use HasFactory;

    protected $fillable = ['nama'];

    public function bobotNegaras()
    {
        return $this->hasMany(\App\Models\BobotNegara::class);
    }

}
