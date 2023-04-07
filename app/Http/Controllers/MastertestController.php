<?php

namespace App\Http\Controllers;

use App\Models\Mastertest;
use Illuminate\Http\Request;
use Validator;
use Auth;
use App\Models\User;

class MastertestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $series_names = Mastertest::select('series_name')->distinct()->get();
        $selected_series_name = $request->input('series_name');
        $mastertests = User::query()
          ->find(Auth::user()->id)
          ->mastertests();
        
        $sortOrder = ['UR', 'HR', 'SR', 'CHR', 'SAR', 'CSR', 'AR', 'S', 'K', 'H', 'A', 'PR', 'TR', 'RRR', 'RR', 'R', 'UC', 'U', 'C'];
        if (!empty($selected_series_name)) {
            $mastertests = $mastertests->where('series_name', $selected_series_name);
        }
    
        $mastertests = $mastertests->orderByRaw('FIELD(rarerity, "'.implode('", "', $sortOrder).'")')
                                   ->paginate(80); // 1ページあたり10件のアイテムを表示する場合
    
        return response()->view('commons.index', compact('mastertests', 'series_names', 'selected_series_name'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $series_names = Mastertest::select('series_name')->distinct()->get();
        $selected_series_name = $request->input('series_name');
        $mastertests = Mastertest::getAllOrderByPrice();
        $sortOrder = ['UR', 'HR', 'SR', 'CHR', 'SAR', 'CSR', 'AR', 'S', 'K', 'H', 'A', 'PR', 'TR', 'RRR', 'RR', 'R', 'UC', 'U', 'C'];
        if (!empty($selected_series_name)) {
            $mastertests = $mastertests->where('series_name', $selected_series_name)->sortBy(function ($item) use ($sortOrder) {
                return array_search($item->rarerity, $sortOrder);
            });
        }
        else{
            $selected_series_name = Mastertest::getLatestSeriesnameById();
            $mastertests = $mastertests->where('series_name', $selected_series_name)->sortBy(function ($item) use ($sortOrder) {
                return array_search($item->rarerity, $sortOrder);
            });
        }
        return response()->view('commons.edit', compact('mastertests', 'series_names', 'selected_series_name'));
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
    public function show($id)
    {
        $mastertest = Mastertest::find($id);
        return response()->view('commons.show',compact('mastertest'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mastertest $mastertest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mastertest $mastertest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mastertest $mastertest)
    {
        //
    }
    
    public function mypage(){
        $user = User::find(Auth::id());

        $data =[0,0];
        $mastertests=$user->mastertests()->get();
        foreach($mastertests as $mastertest){
            $price = intval(explode(',',$mastertest->price)[0]);
            $stock =$mastertest->users()
                   ->wherePivot('user_id', Auth::id())
                   ->withPivot('stock')
                   ->first()
                   ->pivot
                   ->stock;
            $data[0] += $price * $stock;
            $data[1] += $stock;
        }
        $assets = User::query()
          ->find(Auth::user()->id)
          ->assets()
          ->orderBy('created_at','desc')
          ->get();
                
        return response()->view('commons.mypage', compact('data','assets'));
    }

    
    public function increment(Request $request, $id)
    {
        $mastertest = Mastertest::find($id);
        
        $mastertest->users()
                   ->wherePivot('user_id', Auth::id())
                   ->withPivot('stock')
                   ->first()
                   ->pivot
                   ->increment('stock');
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
    
      
        public function decrement(Request $request, $id)
        {
            $mastertest = Mastertest::find($id);
            $mastertest->users()
                ->wherePivot('user_id', Auth::id())
                ->withPivot('stock')
                ->first()
                ->pivot
                ->decrement('stock');
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

      
          
    public function index_result(Request $request)
    {
        $series_names = Mastertest::select('series_name')->distinct()->get();
        $keyword = $request->series_name;
        $mastertests = Mastertest::query()
            ->where('series_name','like',"%{$keyword}%")
            ->get();
        return response()->view('commons.index',compact('mastertests','series_names'));
    }
}
