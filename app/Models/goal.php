<?php

namespace App\Models;

use App\Models\wallet;
use App\Models\goalcategory;
use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    protected $fillable = ['user_id', 'goal_category_id', 'target_amount', 'current_amount', 'target_date','status'];
// Goal belongs to a category

    public function goal_category()
    {
        return $this->belongsTo(goalcategory::class, 'goal_category_id');
    }
    public function wallet()
{
    return $this->belongsTo(wallet::class);
}
public function user()
{
    return $this->belongsTo(User::class);
}


// Goal has many transactions
public function transactions()
{
    return $this->hasMany(GoalTransaction::class);
}

// Goal belongs to many wallets (pivot table)
public function wallets()
{
    return $this->belongsToMany(Wallet::class, 'goal_wallets')
                ->withPivot('amount')
                ->withTimestamps();
}
}

