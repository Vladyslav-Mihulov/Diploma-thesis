<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Search extends Model
{
    protected $table = 'searches';

    public $timestamps = false;

    protected $fillable = [
        'address',
        'city',
        'state',
        'postcode',
        'lat',
        'lng',
        'category',
        'distance',
        'created_at',
        'users_id',
    ];

    public function results()
    {
        return $this->hasMany(Result::class, 'searches_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }
}