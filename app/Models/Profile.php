<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'first_name', 'last_name', 'birthday', 'timezone', 'local', 'user_img_path'
    ];
    // protected $casts = [
    //     'birthday' => 'date'
    // ];

    public function User()
    {
        return $this->belongsTo(User::class);
    }
    public function getFullNameAttribute($value)
    {
        $first_name = $this->first_name;
        $last_name = $this->last_name;
        return $first_name . " " . $last_name;
    }
}
