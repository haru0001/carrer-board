<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TagMap extends Model
{
    protected $fillable = ['user_id', 'tag_id'];
}
