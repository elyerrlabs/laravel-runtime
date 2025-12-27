<?php

namespace Elyerr\LaravelRuntime\Command;


final class ModelMakeCommand extends \Illuminate\Foundation\Console\ModelMakeCommand
{

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        if (!is_dir(app_path('Models'))) {
            mkdir(app_path('Models'));
        }

        return is_dir(app_path('Models')) ? $rootNamespace . '\\Models' : $rootNamespace;
    }
}
