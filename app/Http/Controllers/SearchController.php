<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mastertest;
use Auth;
use App\Models\User;

class SearchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function edit_result(Request $request)
    {
        $series_names = Mastertest::select('series_name')->distinct()->get();
        $keyword = trim($request->series_name);
        $mastertests = Mastertest::query()
            ->where('series_name','like',"%{$keyword}%")
            ->get();
        return response()->view('commons.edit',compact('mastertests','series_names'));
    }
    
    public function index_result(Request $request)
    {
        $series_names = Mastertest::select('series_name')->distinct()->get();
        $keyword = $request->series_name;
        $mastertests = Mastertest::query()
            ->where('series_name','like',"%{$keyword}%")
            ->get();
        return response()->view('commons.index',compact('mastertests','series_names'));
    }
    
    public function keyword_result(Request $request)
    {
          $validatedData = $request->validate([
              'keyword' => 'required|min:1|max:30',
          ]);
          $series_names = Mastertest::select('series_name')->distinct()->get();
          $selected_series_name = 'すべてのシリーズ';
          $keywords =  explode(' ', str_replace('　', ' ', trim($request->keyword)));
          $sortOrder = ['UR', 'HR', 'SR', 'CHR', 'SAR', 'CSR', 'AR', 'S', 'K', 'H', 'A', 'PR', 'TR', 'RRR', 'RR', 'R', 'UC', 'U', 'C','-'];
          foreach($keywords as $keyword){
              $mastertests = Mastertest::query()
                ->where('name', 'like', "%{$keyword}%")
                ->orWhere('number', 'like', "%{$keyword}%")
                ->orWhere('rarerity', 'like', "%{$keyword}%")
                ->orWhere('series_name', 'like', "%{$keyword}%")
                ->orWhere('series_number', 'like', "%{$keyword}%")
                ->orderByRaw("FIELD(rarerity, '".implode("','", $sortOrder)."')")
                ->paginate(60);
          }

        return response()->view('commons.edit',compact('mastertests','series_names','selected_series_name'));
    }

    public function mypage_keyword_result(Request $request)
    {
          $validatedData = $request->validate([
              'keyword' => 'required|min:1|max:30',
          ]);
          $series_names = User::query()->find(Auth::user()->id)->mastertests()->select('series_name')->distinct()->get();
          $selected_series_name = 'すべてのシリーズ';
          $keywords =  explode(' ', str_replace('　', ' ', trim($request->keyword)));
          $sortOrder = ['UR', 'HR', 'SR', 'CHR', 'SAR', 'CSR', 'AR', 'S', 'K', 'H', 'A', 'PR', 'TR', 'RRR', 'RR', 'R', 'UC', 'U', 'C','-'];
          foreach($keywords as $keyword){
              $mastertests = User::query()->find(Auth::user()->id)->mastertests()
                ->where('name', 'like', "%{$keyword}%")
                ->orWhere('number', 'like', "%{$keyword}%")
                ->orWhere('rarerity', 'like', "%{$keyword}%")
                ->orWhere('series_name', 'like', "%{$keyword}%")
                ->orWhere('series_number', 'like', "%{$keyword}%")
                ->orderByRaw("FIELD(rarerity, '".implode("','", $sortOrder)."')")
                ->paginate(60);
          }

        return response()->view('commons.edit',compact('mastertests','series_names','selected_series_name'));
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
    public function store(Request $request)
    {
        //
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
    public function destroy(string $id)
    {
        //
    }
}
