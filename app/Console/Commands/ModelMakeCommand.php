<?php

namespace App\Console\Commands;

use Illuminate\Foundation\Console\ModelMakeCommand as Command;

class ModelMakeCommand extends Command
{
    protected function getDefaultNamespace ($rootNamespace)
    {
        // Overides the parent class method
        // to store models in "app/Models/" directory
        // instead of in root path "app/""
        return "{$rootNamespace}\Models";
    }

    protected function getStub ()
    {
        if ($this->option('pivot')) {
            return __DIR__ . '/stubs/pivot.model.stub';
        }

        return __DIR__ . '/stubs/model.stub';
    }
}
