<?php

namespace Elyerr\LaravelRuntime\Command;

use Illuminate\Support\Str;

final class TestMakeCommand extends \Illuminate\Foundation\Console\TestMakeCommand
{
    /**
     * Get the root namespace for the class.
     *
     * @return string
     */
    protected function rootNamespace()
    {
        return $this->getTestNamespaceFromComposer()[0];
    }

    /**
     * Get the destination class path.
     *
     * @param  string  $name
     * @return string
     */
    protected function getPath($name)
    {
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);
        return base_path($this->getTestNamespaceFromComposer()[1]) . str_replace('\\', '/', $name) . '.php';
    }


    protected function getTestNamespaceFromComposer(): array
    {
        $composer = json_decode(
            file_get_contents(base_path('composer.json')),
            true
        );

        $psr4 = $composer['autoload']['psr-4'] ?? [];

        foreach ($psr4 as $namespace => $path) {
            if (str_ends_with($namespace, 'Tests\\')) {
                return [$namespace, $path];
            }
        }

        throw new \RuntimeException(
            'No PSR-4 namespace ending with "Test\\" was found in composer.json.'
        );
    }

    /**
     * Resolve the fully-qualified path to the stub.
     *
     * @param  string  $stub
     * @return string
     */
    protected function resolveStubPath($stub)
    {
        $customPath = __DIR__ . $stub;

        if (file_exists($customPath)) {
            return $customPath;
        }

        return $this->laravel->basePath(trim($stub, '/'));
    }


    /**
     * Summary of replaceNamespace
     * @param mixed $stub
     * @param mixed $name
     * @return static
     */
    protected function replaceNamespace(&$stub, $name)
    {
        parent::replaceNamespace($stub, $name);

        $testCaseNamespace = rtrim($this->rootNamespace(), '\\') . '\\TestCase';

        $stub = str_replace(
            ['{{ namespacedTestCase }}', 'DummyTestCase'],
            [$testCaseNamespace, $testCaseNamespace],
            $stub
        );

        return $this;

    }
}
