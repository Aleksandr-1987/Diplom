<?php

namespace App\Models\data;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HousekeeperPreference extends Model
{
    use HasFactory;
    protected $fillable = ['title'];
}