<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    protected $table = 'messages';

    public function user_data_to_message()
    {
        return $this->belongsTo(User::class, "receive_id", "id");
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'send_id', 'id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receive_id', 'id');
    }
}
