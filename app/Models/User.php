<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'send_id', 'id');
    }

    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receive_id', 'id');
    }

    public function friendSendersData()
    {
        return $this->belongsTo(Friendship::class, 'id', 'sender_user_id');
    }
}
