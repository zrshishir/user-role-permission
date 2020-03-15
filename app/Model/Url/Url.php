<?php

namespace App\Model\Url;

use Illuminate\Database\Eloquent\Model;

class Url extends Model
{
    protected $table = "urls";
    protected $fillable = ['title'];
}
