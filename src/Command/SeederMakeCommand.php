<?php

namespace Elyerr\LaravelRuntime\Command;


final class SeederMakeCommand extends \Illuminate\Database\Console\Seeds\SeederMakeCommand
{
    /**
     * Get the root namespace for the class.
     *
     * @return string
     */
    protected function rootNamespace()
    {
        return $this->getSeederNamespaceFromComposer();
    }

    protected function getSeederNamespaceFromComposer(): string
    {
        $composer = json_decode(
            file_get_contents(base_path('composer.json')),
            true
        );

        $psr4 = $composer['autoload']['psr-4'] ?? [];

        foreach ($psr4 as $namespace => $path) {
            if (str_ends_with($namespace, 'Database\\Seeders\\')) {
                return $namespace;
            }
        }

        throw new \RuntimeException(
            'No PSR-4 namespace ending with "Database\\Seeders\\" was found in composer.json.'
        );
    }

}

