<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'content',
        'ip',
        'user_agent',
        'comentable_id',
        'comentable_type',
        'created_at',
        'updated_at'
    ];

    public function classwork()
    {
        return $this->belongsTo(Classwork::class, 'comentable_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function comentable()
    {
        return $this->morphTo();
    }
}
