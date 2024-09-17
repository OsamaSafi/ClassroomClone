<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    use HasFactory;
    public function plans()
    {
        return $this->belongsToMany(Plan::class, 'plan_feature')->withPivot(['feature_value']);
    }

    public function price(): Attribute
    {
        return new Attribute(
            set: fn ($price) => $price * 100,
            get: fn ($price) => $price / 100
        );
    }
}
