<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Matstertest;
use Auth;

class Card extends Model
{
    use HasFactory;
  // アプリケーション側でcreateなどできない値を記述する  
  protected $guarded = [
    'id',
    'created_at',
    'updated_at',
  ];
  
//   public static function getAllOrderByPrice()
//   {
//     return self::orderBy('price', 'desc')->get();
//   }
  
//   public function users()
//   {
//     return $this->belongsToMany(User::class)->withTimestamps();
//   }
    public function mastertests()
    {
        return $this->belongsToMany(Mastertest::class)->withTimestamps();
    }
    
  public function store(Card $card)
  {
    $card->users()->attach(Auth::id());
    return redirect()->route('commons.index');
  }

  // 🔽 編集（`destroy()` の `()` 内も異なるので注意）
  public function destroy(Card $card)
  {
    $tweet->users()->detach(Auth::id());
    return redirect()->route('commons.index');
  }
}
