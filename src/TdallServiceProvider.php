<?php

namespace Yhif\Tdall;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Laravel\Ui\UiCommand;

class TdallServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        UiCommand::macro('tdall', function ($command) {
            TdallPreset::install();

            $command->info('TDALL preset scaffolding installed successfully.');

            if ($command->option('auth')) {
                TdallPreset::installAuth();

                $command->info('Auth scaffolding installed successfully.');
            }

            $command->comment('Please run "npm install && npm run dev" to compile your new assets.');
        });

        Paginator::defaultView('pagination::default');

        Paginator::defaultSimpleView('pagination::simple-default');
    }
}
