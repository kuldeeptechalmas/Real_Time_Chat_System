<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Friendship extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'friendships';

    public function sendersData()
    {
        return $this->belongsTo(User::class, 'sender_user_id', 'id');
    }
    public function receiverData()
    {
        return $this->belongsTo(User::class, 'receiver_user_id', 'id');
    }
}
