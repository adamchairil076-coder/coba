<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'author',
        'thumbnail',
        'body',
        'goals',
        'raised',
        'deadline',
    ];

    public function donations()
    {
        return $this->hasMany(Donation::class);
    }

    public function withdrawals()
    {
        return $this->hasMany(Withdrawal::class);
    }
}