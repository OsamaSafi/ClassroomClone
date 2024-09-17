<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Classwork extends Model
{
    use HasFactory;

    public static function booted()
    {
        static::creating(function (Classwork $classwork) {
            if (!$classwork->published_at) {
                $classwork->published_at = now();
            }
        });
    }
    protected $fillable = [
        'classroom_id', 'user_id', 'topic_id', 'title', 'description',
        'status', 'type', 'published_at', 'options'
    ];

    protected $casts = [
        'options' => 'json',
        'published_at' => 'datetime'
    ];

    public function classroom()
    {
        return $this->belongsTo(Classroom::class, 'classroom_id', 'id');
    }
    public function topic()
    {
        return $this->belongsTo(Topic::class, 'topic_id', 'id');
    }

    public function users()
    {
        return $this->belongsToMany(
            User::class,
            'classwork_user',
            'classwork_id',
            'user_id',
            'id',
            'id'
        )
            ->using(ClassworkUser::class)
            ->withPivot(['grade', 'user_id', 'classwork_id', 'status', 'submitted_at']);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function comments()
    {
        return $this->morphMany(Comment::class, 'comentable')->latest();
    }
    public function getPublishedDateAttribute()
    {
        if ($this->published_at) {
            return $this->published_at->format('Y-m-d');
        }
    }
    public function scopeSearch(Builder $builder, $filters)
    {
        $builder->when($filters['search'] ?? '', function ($builder, $value) {
            $builder->where(function ($builder) use ($value) {
                $builder->where(
                    'title',
                    'LIKE',
                    "%{$value}%"
                )->orWhere(
                    'description',
                    'LIKE',
                    "%{$value}%"
                );
            });
        });
        $builder->when($filters['type'] ?? "", function ($builder, $value) {
            $builder->where('type', '=', $value);
        });
    }
    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }
}
