<?php

namespace App\Models;

use App\Models\Scopes\UserClassroomScope;
use App\Observers\ClassroomObserver;
use Attribute;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Classroom extends Model
{
    use HasFactory, SoftDeletes;

    public static string $disk = 'public';

    protected $fillable = [
        'name',
        'code',
        'section',
        'subject',
        'room',
        'cover_image_path',
        'user_id'
    ];

    public static function storeCoverImage($file)
    {
        return $file->store('/covers', self::$disk);
    }

    public static function deleteCoverImage($path)
    {
        if ($path && Storage::disk(self::$disk)->exists($path)) {
            return Storage::disk(self::$disk)->delete($path);
        }
    }

    // global scope
    // لو بدي هاد السكوب في اكتر من مودل بعمل سكوب كلاس
    protected static function booted()
    {
        self::observe(ClassroomObserver::class);
        self::addGlobalScope(new UserClassroomScope);
    }
    ///////////////////////////////////////////////////////

    public function classworks()
    {
        return $this->hasMany(Classwork::class, 'classroom_id', 'id');
    }
    public function topics()
    {
        return $this->hasMany(Topic::class, 'classroom_id', 'id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'classroom_user', 'classroom_id', 'user_id', 'id', 'id')->withPivot(['role']);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function teachers()
    {
        return $this->users()->wherePivot('role', 'teacher');
    }
    public function students()
    {
        return $this->users()->wherePivot('role', 'student');
    }

    public function streams()
    {
        return $this->hasMany(Stream::class);
    }

    public function scopeActive(Builder $query)
    {
        return $query->where('status', '=', 'active');
    }
    public function scopeSearch(Builder $query, $name)
    {
        return $query->where('name', '=', $name);
    }

    public function scopeStatus(Builder $query, $status)
    {
        return $query->where('status', '=', $status);
    }
    public function scopeFilter(Builder $builder, $filters)
    {
        $builder->when($filters['filter'] ?? "", function ($builder, $value) {
            $builder->where(
                'name',
                'LIKE',
                "%{$value}%"
            );
        });
    }

    public function messages()
    {
        return $this->morphMany(Message::class, 'recipient');
    }

    public function join($user_id, $role = 'student')
    {
        $exists = $this->users()->where('user_id', '=', $user_id)->exists();;
        if ($exists) {
            throw new Exception('User Already join in the classroom');
        }
        $this->users()->attach($user_id, [
            'role' => $role,
            'created_at' => now()
        ]);

        // DB::table('classroom_user')->insert([
        //     'classroom_id' => $this->id,
        //     'user_id' => $user_id,
        //     'role' => $role,
        //     'created_at' => now(),
        // ]);
    }

    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = strtolower($value);
    }
}
