<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PHPUnit\Event\Application\Started;
use Illuminate\Support\Str;

class Stream extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'user_id',
        'classroom_id',
        'content',
        'link',
    ];

    public static function booted()
    {
        // static::creating(function (Stream $stream) {
        //     $stream->id = Str::uuid();
        // });
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }
}
