<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Table1 extends Model
{
    protected $table = 'table1';
    protected $fillable = ['title', 'content']; // assign which column can be edited
}
