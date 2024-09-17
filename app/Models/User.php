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

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_image'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function classrooms()
    {
        return $this->belongsToMany(
            Classroom::class,
            'classroom_user',
            'user_id',
            'classroom_id',
            'id',
            'id'
        )->withPivot([
            'role'
        ]);
    }

    public function plans()
    {
        return $this->belongsToMany(Plan::class, 'subscriptions');
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function classroom()
    {
        return $this->hasOne(Classroom::class);
    }

    public function classwork()
    {
        return $this->hasOne(Classwork::class);
    }
    public function classworks()
    {
        return $this->belongsToMany(
            Classwork::class,
            'classwork_user',
            'user_id',
            'classwork_id',
            'id',
            'id'
        )
            ->using(ClassworkUser::class)
            ->withPivot([
                'grade',
                'status',
                'submitted_at',
                'created_at'
            ]);
    }

    public function streams()
    {
        return $this->hasMany(Stream::class);
    }

    public function profile()
    {
        return $this->hasOne(Profile::class)->withDefault();
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }
    // ----------------------Start Relashion for chating-----------------
    public function receivedMessages()
    {
        return $this->morphMany(Message::class, 'recipient');
    }

    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }
    // ----------------------End Relashion for chating-----------------
}
