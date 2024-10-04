<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'classwork_id', 'content','grade'
    ];

    public function classwork()
    {
        return $this->belongsTo(Classwork::class);
    }
    public function user()
    {
        return $this->belongsTo(Classwork::class);
    }
}
