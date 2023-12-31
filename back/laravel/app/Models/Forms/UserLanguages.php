<?php

namespace App\Models\Forms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLanguages extends Model
{
    use HasFactory;
    protected $fillable = [ 'user_id', 'language_id' ];
}
