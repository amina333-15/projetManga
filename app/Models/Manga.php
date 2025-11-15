<?php

namespace App\Models;
use App\Services\MangaService;

use Illuminate\Database\Eloquent\Model;

class Manga extends Model
{
    protected $table = 'manga';
    protected $primaryKey = 'id_manga';
    public $timestamps = false;
}

