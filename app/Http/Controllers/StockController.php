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
        return redirect()->route('mastertest.create');
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
        return redirect()->route('mastertest.create');
      }

}
