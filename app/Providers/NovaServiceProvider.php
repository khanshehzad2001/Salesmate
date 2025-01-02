<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;
use Psy\Readline\Hoa\Console;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        Nova::auth(function ($request) {
            return $request->user()->isAdmin();
        });

        Nova::footer(function ($request){
            $year = now()->year;
            $copyrightText = "&copy; $year Ecity Electronics";
            return $copyrightText;
        });

        Nova::createUserUsing(function($command) {
            return [
                $command->ask('Name'),
                $command->ask('Email Address'),
                $command->secret('Password'),
                //Custom prompts:
                $command->ask('Phone Number with country code(e.g. 971)'),
                $command->confirm('Is Admin?', false),
            ];
        }, function($name, $email, $password, $phone_number,$is_admin) {
            (new User)->forceFill([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
                //Custom fields:
                'phone_number' => $phone_number,
                'is_admin' => $is_admin,
             ])->save();
        });
    }

    /**
     * Register the Nova routes.
     *
     * @return void
     */
    protected function routes()
    {
        Nova::routes()
                ->withAuthenticationRoutes()
                ->withPasswordResetRoutes()
                ->register();
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define('viewNova', function ($user) {
            // return in_array($user->email, [
            //     //
            // ]);
            
            return $user->isAdmin();
        });
    }

    /**
     * Get the dashboards that should be listed in the Nova sidebar.
     *
     * @return array
     */
    protected function dashboards()
    {
        return [
            new \App\Nova\Dashboards\Main,
        ];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools()
    {
        return [
            
        ];
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
