<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    protected $guarded = ['id'];
    public function messages()
    {
        $this->hasMany(Message::class);
    }
}
