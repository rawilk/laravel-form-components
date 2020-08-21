<?php

namespace Rawilk\LaravelFormComponents\Commands;

use Illuminate\Console\Command;

class LaravelFormComponentsCommand extends Command
{
    public $signature = 'laravel-form-components';

    public $description = 'My command';

    public function handle()
    {
        $this->comment('All done');
    }
}
