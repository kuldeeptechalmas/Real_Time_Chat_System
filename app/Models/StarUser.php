<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StarUser extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'staruser';

    public function starUserFind()
    {
        return $this->belongsTo(User::class, 'id', 'star_user_id');
    }
}
