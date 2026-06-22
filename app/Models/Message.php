<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    // 🌟 Siguraduhing idinagdag ang 'file_path' at 'file_type' dito sa fillable array
    protected $fillable = [
        'sender_id',
        'receiver_id',
        'message',
        'file_path',
        'file_type',
        'is_read',
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}