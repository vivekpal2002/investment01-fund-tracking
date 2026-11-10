<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class investment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'investment_type_id', 'category_id',
        'asset_name', 'quantity', 'buy_price',
        'current_price', 'buy_date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function investmentType()
    {
        return $this->belongsTo(InvestmentType::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
