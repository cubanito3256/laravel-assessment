<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = ['title', 'message', 'recipient', 'created_by'];
    protected $hidden = ['created_by', 'recipient', 'read', 'updated_at'];
}
