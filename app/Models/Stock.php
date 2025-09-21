<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $table='stocks';
    protected $fillable = [
        'user_id', 'name', 'ticker', 'quantity', 'avg_price', 'invested_amount',
        'current_price', 'change_percent', 'exchange', 'sector', 'icon', 'color'
    ];
}
