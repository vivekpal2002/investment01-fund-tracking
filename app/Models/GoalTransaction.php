<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoalTransaction extends Model
{

    protected $fillable = [
        'goal_id',
        'wallet_id',
        'user_id',
        'amount',
        'balance_after',
        'description',
    ];

    public function goal()
    {
        return $this->belongsTo(Goal::class);
    }

    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
