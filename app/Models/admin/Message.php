<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $table = 'message';

    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'description',
    ];
}
