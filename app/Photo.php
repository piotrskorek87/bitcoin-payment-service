<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Item;

class Photo extends Model
{
    protected $fillable = ['filename', 'thumbnail'];

    public function photo()
    {
    	return $this->belongsTo(Item::class);
    }

    public function scopeThubnail($query){
        return $query->where('thumbnail', 1);
    } 
}
