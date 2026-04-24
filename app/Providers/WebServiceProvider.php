<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\UserInterface;
use App\Repositories\UserRepository;

class WebServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            UserInterface::class,
            UserRepository::class
        );
    }
}
