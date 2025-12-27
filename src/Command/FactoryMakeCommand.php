<?php

namespace Elyerr\LaravelRuntime\Command;

use Illuminate\Support\Str;

final class FactoryMakeCommand extends \Illuminate\Database\Console\Factories\FactoryMakeCommand
{
    protected function buildClass($name)
    {
        $stub = $this->files->get($this->getStub());

        $factory = class_basename(Str::ucfirst(str_replace('Factory', '', $name)));

        $namespaceModel = $this->option('model')
            ? $this->qualifyModel($this->option('model'))
            : $this->qualifyModel($this->guessModelName($name));

        $model = class_basename($namespaceModel);


        $factoryNamespace = rtrim($this->getFactoryNamespaceFromComposer(), '\\');

        $replace = [
            '{{ factoryNamespace }}' => $factoryNamespace,
            'NamespacedDummyModel' => $namespaceModel,
            '{{ namespacedModel }}' => $namespaceModel,
            '{{namespacedModel}}' => $namespaceModel,
            'DummyModel' => $model,
            '{{ model }}' => $model,
            '{{model}}' => $model,
            '{{ factory }}' => $factory,
            '{{factory}}' => $factory,
        ];

        $stub = str_replace(array_keys($replace), array_values($replace), $stub);

        return $this->replaceNamespace($stub, $name)
            ->replaceClass($stub, $name);
    }



    protected function getFactoryNamespaceFromComposer(): string
    {
        $composer = json_decode(
            file_get_contents(base_path('composer.json')),
            true
        );

        $psr4 = $composer['autoload']['psr-4'] ?? [];

        foreach ($psr4 as $namespace => $path) {
            if (str_ends_with($namespace, 'Database\\Factories\\')) {
                return $namespace;
            }
        }

        throw new \RuntimeException(
            'No PSR-4 namespace ending with "Database\\Factories\\" was found in composer.json.'
        );
    }
}
