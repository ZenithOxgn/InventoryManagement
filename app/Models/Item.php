<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    //
    protected $fillable = ['name','description','category_id','stock_level','price'];

    public function category(){

        return $this->belongsTo(Category::class);
    }
}
