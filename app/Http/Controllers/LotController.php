<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLotRequest;
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

    public function store(CreateLotRequest $request)
    {
        $data = $request->validated();
        $newLot = Lot::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'start_price'=> $data['start_price'],
            'user_id' => auth()->user()->id
        ]);
        foreach($data['categories'] as $category) {
            $newLot->categories()->attach($category);
        }
        return redirect()->route('dashboard.index')->with('success', 'Lot created successfully');
    }

    public function update(CreateLotRequest $request, Lot $lot)
    {
        $data = $request->validated();
        $lot->title = $data['title'];
        $lot->description = $data['description'];
        $lot->start_price = $data['start_price'];
        $lot->save();
        $lotCategories = $lot->categories->pluck('id')->toArray();
        foreach ($lotCategories as $lotCat) {
            if (!in_array($lotCat, $data['categories'])) {
                $lot->categories()->detach([$lotCat]);
            }
        }
        foreach ($data['categories'] as $category) {
            if (!in_array($category, $lotCategories)) {
                $lot->categories()->attach($category);
            }
        }
        return redirect()->route('dashboard.index')->with('success', 'Lot updated successfully');
    }

    public function destroy(Lot $lot)
    {
        $lot->delete();
        return redirect()->route('dashboard.index')->with('success', 'Lot deleted successfully');
    }
}
