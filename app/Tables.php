<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tables extends Model
{
    protected $table = 'tables';
    protected $fillable = ['number','seats','notes'];
}
