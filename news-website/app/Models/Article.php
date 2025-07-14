<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Article extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'description', 'content','image','url','source','author','category','published_at'];
}
