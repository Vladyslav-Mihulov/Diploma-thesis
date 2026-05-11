<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    protected $table = 'results';

    public $timestamps = false;

    protected $fillable = [
        'place_name',
        'address',
        'lat',
        'lng',
        'distance',
        'description',
        'rating',
        'created_at',
        'searches_id',
    ];

    public function search()
    {
        return $this->belongsTo(Search::class, 'searches_id');
    }
}