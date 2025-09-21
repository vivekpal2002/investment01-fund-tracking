<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;


class GoalWallet extends Pivot
{
    protected $table = 'goal_wallets';

    protected $fillable = [
        'goal_id',
        'wallet_id',
        'amount',
    ];
}
