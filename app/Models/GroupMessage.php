<?php

namespace App\Models;
use App\Models\Group;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class GroupMessage extends Model
{
    protected $guarded = ['id'];
    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
