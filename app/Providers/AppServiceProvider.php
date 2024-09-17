<?php

namespace App\Providers;

use App\Models\Classroom;
use App\Models\Classwork;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();
        Relation::enforceMorphMap([
            'classwork' => Classwork::class,
            'user' => User::class,
            'comment' => Comment::class,
            'classroom' => Classroom::class
        ]);
    }
}
