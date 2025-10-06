<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;

class ApiRequestCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:api-request {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'create a new api request class';

    protected function getStub()
    {
        return __DIR__ . '/stub/api-request.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '/Http/ApiRequests';
    }
}
