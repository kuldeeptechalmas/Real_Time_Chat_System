<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GroupMessageDeleteAt extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'group_message_delete_at';
}
