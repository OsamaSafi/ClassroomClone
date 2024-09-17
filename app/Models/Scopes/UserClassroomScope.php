<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserClassroomScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        if ($id = Auth::id()) {
            $builder->where('classrooms.user_id', '=', $id)
                ->orWhereExists(function ($query) use ($id) {
                    $query->select(DB::raw('1'))
                        ->from('classroom_user as cu')
                        ->whereColumn('cu.classroom_id', '=', 'classrooms.id')
                        ->where('cu.user_id', '=', $id);
                });

            //هاد الامر رح يتطبق على كل عملية سيليكت
        }
    }
}
// يعني بدي يظهر الكلاس رووم لليوزر يلي عامل لوجن و عامل جوين
// select *
// from classroom
// where user_id = Auth::id
// or classroom_id exsits(select 1 from classroom_user where classroom_id = classrooms.id and user_id = Auth::id())
// ============================================= anuther soluthion =========================================================
// or classrooms.id in (select classroom_id from classroom_user where classroom_id = classrooms.id and user_id = Auth::id())
