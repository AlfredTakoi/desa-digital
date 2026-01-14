<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\UserRepository;
use App\Interfaces\UserRepositoryInterface;
use App\Repositories\HeadOfFamilyRepository;
use App\Interfaces\HeadOfFamilyRepositoryInterface;
use App\Repositories\FamilyMemberRepository;
use App\Interfaces\FamilyMemberRepositoryInterface;
use App\Repositories\SocialAssistanceRepository;
use App\Interfaces\SocialAssistanceRepositoryInterface;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(HeadOfFamilyRepositoryInterface::class, HeadOfFamilyRepository::class);
        $this->app->bind(FamilyMemberRepositoryInterface::class, FamilyMemberRepository::class);
        $this->app->bind(SocialAssistanceRepositoryInterface::class, SocialAssistanceRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
