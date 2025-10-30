<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Support\Facades\Auth;
use App\Models\Group;
use App\Models\Message;

class User extends Authenticatable implements HasMedia
{
    use HasFactory, Notifiable, InteractsWithMedia, SoftDeletes;

    protected $guarded = ['id'];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'last_seen_at' => 'datetime',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /** ----------------------------
     *  FRIEND RELATIONSHIPS
     * ---------------------------- */
    public function friends()
    {
        return $this->belongsToMany(User::class, 'friends', 'user_id', 'friend_id')->withTimestamps();
    }

    public function friendOf()
    {
        return $this->belongsToMany(User::class, 'friends', 'friend_id', 'user_id')->withTimestamps();
    }

    public function allFriends()
    {
        // Access as properties (collections), not relations
        return $this->friends->merge($this->friendOf);
    }

    /** ----------------------------
     *  GROUP RELATIONSHIPS
     * ---------------------------- */

    // Groups created by this user
    public function groups()
    {
        return $this->hasMany(Group::class, 'created_by');
    }

    // Groups where the user is a member
    public function memberGroups()
    {
        return $this->belongsToMany(Group::class, 'group_members', 'user_id', 'group_id')
            ->withPivot('is_admin')
            ->withTimestamps();
    }

    public function allGroups()
    {
        // Use property access to get collections, not relations
        $createdGroups = $this->groups;       // ✅ returns a Collection
        $joinedGroups  = $this->memberGroups; // ✅ returns a Collection

        // Merge both collections and remove duplicates
        return $createdGroups->merge($joinedGroups)->unique('id')->values();
    }

    /** ----------------------------
     *  MESSAGES
     * ---------------------------- */
    public function getLastMessageAttribute()
    {
        return Message::where(function ($query) {
            $query->where('sender_id', Auth::id())
                ->where('receiver_id', $this->id);
        })
            ->orWhere(function ($query) {
                $query->where('sender_id', $this->id)
                    ->where('receiver_id', Auth::id());
            })
            ->latest()
            ->first();
    }
}
