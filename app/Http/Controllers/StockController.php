<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mastertest;
use Auth;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
        public function store(Mastertest $mastertest)
      {
        $mastertest->users()->attach(Auth::id());
        $series_names = Mastertest::select('series_name')->distinct()->get();
        $selected_series_name = $mastertest->series_name;
        $mastertests = Mastertest::getAllOrderByPrice();
        $sortOrder = ['UR', 'HR', 'SR', 'CHR', 'SAR', 'CSR', 'AR', 'S', 'K', 'H', 'A', 'PR', 'TR', 'RRR', 'RR', 'R', 'UC', 'U', 'C'];
        if (!empty($selected_series_name)) {
            $mastertests = $mastertests->where('series_name', $selected_series_name)->sortBy(function ($item) use ($sortOrder) {
                return array_search($item->rarerity, $sortOrder);
            });
        }
        return response()->view('commons.edit', compact('mastertests', 'series_names', 'selected_series_name'));
      }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
      public function destroy(Mastertest $mastertest)
      {
        $mastertest->users()->detach(Auth::id());
        $series_names = Mastertest::select('series_name')->distinct()->get();
        $selected_series_name = $mastertest->series_name;
        $mastertests = Mastertest::getAllOrderByPrice();
        $sortOrder = ['UR', 'HR', 'SR', 'CHR', 'SAR', 'CSR', 'AR', 'S', 'K', 'H', 'A', 'PR', 'TR', 'RRR', 'RR', 'R', 'UC', 'U', 'C'];
        if (!empty($selected_series_name)) {
            $mastertests = $mastertests->where('series_name', $selected_series_name)->sortBy(function ($item) use ($sortOrder) {
                return array_search($item->rarerity, $sortOrder);
            });
        }
        return response()->view('commons.edit', compact('mastertests', 'series_names', 'selected_series_name'));
      }

}
