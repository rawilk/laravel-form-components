<?php

declare(strict_types=1);

namespace Rawilk\FormComponents\Console;

use Illuminate\Console\Command;
use Rawilk\FormComponents\FormComponentsServiceProvider;

class PublishCommand extends Command
{
    protected $signature = 'fc:publish
                            {--views : Publish the views as well}
                            {--lang : Publish the lang files}
    ';

    protected $description = 'Publish the config file for form-components.';

    public function handle(): void
    {
        $this->call('vendor:publish', [
            '--provider' => FormComponentsServiceProvider::class,
            '--tag' => 'config',
            '--force' => true,
        ]);

        if ($this->option('views')) {
            $this->call('vendor:publish', [
                '--provider' => FormComponentsServiceProvider::class,
                '--tag' => 'views',
                '--force' => true,
            ]);
        }

        if ($this->option('lang')) {
            $this->call('vendor:publish', [
                '--provider' => FormComponentsServiceProvider::class,
                '--tag' => 'lang',
                '--force' => true,
            ]);
        }
    }
}
