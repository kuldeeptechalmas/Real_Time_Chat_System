<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group_Message_Emoji extends Model
{
    use HasFactory;
    protected $table = 'group_message_emoji';

    public function UserData()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
