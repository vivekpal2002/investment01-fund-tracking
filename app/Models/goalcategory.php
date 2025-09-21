<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class goalcategory extends Model
{
    protected $table = 'goal_category';
    public function goal()
    {
        return $this->hasMany(goal::class);
    }
}
