<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function rating()
    {
        return $this->hasOne(Rating::class);
    }

    public function review()
    {
        return $this->hasOne(Review::class);
    }


    protected $fillable = [
        'title',
        'description',
        'release_date',
        'genre',
        'user_id',
    ];

}
