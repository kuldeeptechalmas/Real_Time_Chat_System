<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GroupUser extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'group_user';

    public function UserData()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function GroupData()
    {
        return $this->hasOne(Group::class, 'id', 'group_id');
    }

    public function NotViewData()
    {
        return $this->hasMany(GroupMessageDeleteAt::class, 'group_id', 'group_id');
    }
}
