<?php

namespace Elyerr\LaravelRuntime\Command;

use Illuminate\Support\Str;

class ModelMakeCommand extends \Illuminate\Foundation\Console\ModelMakeCommand
{
    /**
     * Resolve the fully-qualified path to the stub.
     *
     * @param  string  $stub
     * @return string
     */
    protected function resolveStubPath($stub)
    {
        return file_exists($customPath = $this->laravel->basePath(trim($stub, '/')))
            ? $customPath
            : __DIR__ . $stub;
    }

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

    /**
     * Decode composer
     * @throws \Exception
     */
    private function decodeComposer()
    {
        if (!file_exists(base_path('composer.json'))) {
            throw new \Exception("composer.json not found");
        }
        return json_decode(file_get_contents(base_path('composer.json')));
    }

    /**
     * Get prefix name
     * @return string
     */
    private function prefix()
    {
        return str_replace("-", "_", explode("/", $this->decodeComposer()->name)[1]) . "_";
    }

    protected function buildClass($name)
    {
        $stub = parent::buildClass($name);

        return $this->replaceTable($stub, $name);
    }

    protected function replaceTable(string $stub, string $name): string
    {
        $table = $this->getTableName($name);

        return str_replace(
            '{{ table }}',
            $table,
            $stub
        );
    }

    protected function getTableName(string $name): string
    {
        $modulePrefix = $this->prefix();

        $table = Str::snake(
            Str::pluralStudly(class_basename($name))
        );

        return $modulePrefix . $table;
    }
}
