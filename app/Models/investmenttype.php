<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class investmenttype extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function investments()
    {
        return $this->hasMany(Investment::class);
    }
}
