<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LanguageJson extends Model
{
    use HasFactory;

    protected $table = 'langs';

    protected $fillable = [
        'lang',
        'translation'
    ];
}
