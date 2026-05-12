<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\UserInterface;
use App\Repositories\UserRepository;
use App\Interfaces\SubmissionInterface;
use App\Repositories\SubmissionRepository;
use App\Interfaces\TaskInterface;
use App\Repositories\TaskRepository;
use App\Interfaces\ClassInterface;
use App\Repositories\ClassRepository;
use App\Interfaces\AkunInterface;
use App\Repositories\AkunRepository;
use App\Interfaces\ClassAccessInterface;
use App\Repositories\ClassAccessRepository;
use App\Interfaces\PelanggaranInterface;
use App\Repositories\PelanggaranRepository;



class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(SubmissionInterface::class, SubmissionRepository::class);
        $this->app->bind(UserInterface::class, UserRepository::class);
        $this->app->bind(TaskInterface::class, TaskRepository::class);
        $this->app->bind(ClassInterface::class, ClassRepository::class);
        $this->app->bind(AkunInterface::class, AkunRepository::class);
        $this->app->bind(ClassAccessInterface::class, ClassAccessRepository::class);
    }

    public function boot(): void
    {
        //
    }
}
