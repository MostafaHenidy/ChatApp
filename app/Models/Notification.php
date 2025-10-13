<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $guarded = ['id'];
    public function sender()
    {
        $this->belongsTo(User::class);
    }
    public function receiver()
    {
        $this->hasMany(User::class);
    }
}
