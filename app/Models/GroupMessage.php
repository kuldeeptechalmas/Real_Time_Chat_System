<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupMessage extends Model
{
    use HasFactory;
    public function UserData()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    public function UserDataAll()
    {
        return $this->hasMany(User::class, 'id', 'user_id');
    }
    public function GroupMessageDeleteAtData()
    {
        return $this->hasMany(GroupMessageDeleteAt::class, 'message_id', 'id');
    }
}
