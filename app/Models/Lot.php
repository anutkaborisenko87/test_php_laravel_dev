<?php

namespace App\Models;

use App\Models\NewAuctionPrice;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Lot extends Model
{
    use HasFactory;

    protected $fillable = [
      'title',
      'description',
      'start_price',
      'auction_price',
      'auction_price',
      'sold',
      'auction_active',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function scopeLastAuctionPriceUser()
    {
        if (!is_null($this->auction_price)) {
            return NewAuctionPrice::where('lot_id', $this->id)->first()->user;
        }
        return $this->auction_price;
    }
}
