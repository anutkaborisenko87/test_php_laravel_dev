<?php

namespace App\Http\Controllers;

use App\Models\Lot;
use App\Models\NewAuctionPrice;
use Illuminate\Http\Request;

class LotController extends Controller
{
    public function setNewPrice(Request $request, $lot_id)
    {
        $lot = Lot::where('id', $lot_id)->first();
        $lot->auction_price = $request->new_auction_price;
        $lot->save();
        $new_auction_price = NewAuctionPrice::where('lot_id', $lot_id)->first();
        if (is_null($new_auction_price)) {
            NewAuctionPrice::create([
               'lot_id' => $lot_id,
               'user_id' => $request->user_id
            ]);
        } else {
            $new_auction_price->user_id = $request->user_id;
            $new_auction_price->save();
        }
        return response()->json(['data' => 'new price written']);

    }
}
