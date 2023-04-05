<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mastertest extends Model
{
    use HasFactory;
    
    
    public static function getAllOrderByPrice()
    {
      return self::orderBy('price', 'desc')->get();
    }
    
    public function users()
      {
        return $this->belongsToMany(User::class)->withTimestamps()->withPivot('stock');
      }
      
    public function stock()
      {
        return $this->belongsToMany(Stock::class)->withTimestamps();
      }
      
    public static function getLatestSeriesnameById()
      {
        return self::latest('id')->value('series_name');
      }
}
