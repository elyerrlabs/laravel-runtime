<?php

namespace Elyerr\LaravelRuntime\App;

use Illuminate\Support\Collection;
use Illuminate\Foundation\Mix;
use Illuminate\Database\Migrations\MigrationCreator;
use Illuminate\Container\Container;
use Illuminate\Filesystem\Filesystem;
use RuntimeException;
use Illuminate\Support\Composer;
use Elyerr\LaravelRuntime\App\ApplicationBuilder;

class Application extends \Illuminate\Foundation\Application
{
    /**
     * Begin configuring a new Laravel application instance.
     *
     * @param  string|null  $basePath
     * @return \Illuminate\Foundation\Configuration\ApplicationBuilder
     */
    public static function configure(?string $basePath = null)
    {
        $basePath = match (true) {
            is_string($basePath) => $basePath,
            default => static::inferBasePath(),
        };

        return (new ApplicationBuilder(new static($basePath)))
            ->withKernels()
            ->withEvents()
            ->withBindings([
                MigrationCreator::class => function ($app) {
                    return new MigrationCreator(
                        $app->make(Filesystem::class),
                        base_path('stubs')
                    );
                },
                Composer::class => function ($app) {
                    return new Composer($app->make(Filesystem::class));
                },
            ])
            ->withCommands([
                \Elyerr\LaravelRuntime\Command\ModelMakeCommand::class,
                \Elyerr\LaravelRuntime\Command\SeederMakeCommand::class,
                \Elyerr\LaravelRuntime\Command\FactoryMakeCommand::class,
                \Elyerr\LaravelRuntime\Command\MigrateMakeCommand::class,
                \Elyerr\LaravelRuntime\Command\TestMakeCommand::class,
                \Elyerr\LaravelRuntime\Command\ComponentMakeCommand::class,
                \Elyerr\LaravelRuntime\Command\ConsoleMakeCommand::class,
                \Elyerr\ApiResponse\Console\TransformerCommand::class
            ])
            ->withProviders();
    }

    /**
     * Register the basic bindings into the container.
     *
     * @return void
     */
    protected function registerBaseBindings()
    {
        static::setInstance($this);

        $this->instance('app', $this);

        $this->instance(Container::class, $this);
        $this->singleton(Mix::class);

        $this->singleton(
            \Illuminate\Foundation\PackageManifest::class,
            fn() =>
            new \Elyerr\LaravelRuntime\App\PackageManifest(
                new Filesystem,
                $this->basePath(),
                $this->getCachedPackagesPath()
            )
        );
    }

    /**
     * Register all of the configured providers.
     *
     * @return void
     */
    public function registerConfiguredProviders()
    {
        $providers = (new Collection($this->make('config')->get('app.providers')))
            ->partition(fn($provider) => str_starts_with($provider, 'Illuminate\\'));

        (new \Illuminate\Foundation\ProviderRepository(
            $this,
            new Filesystem,
            $this->getCachedServicesPath()
        ))->load($providers->collapse()->toArray());

        $this->fireAppCallbacks($this->registeredCallbacks);
    }

    /**
     * Get the application namespace.
     *
     * @return string
     *
     * @throws \RuntimeException
     */
    public function getNamespace()
    {
        if (!is_null($this->namespace)) {
            return $this->namespace;
        }

        $composer = json_decode(file_get_contents($this->basePath('composer.json')), true);

        foreach ((array) data_get($composer, 'autoload.psr-4') as $namespace => $path) {
            foreach ((array) $path as $pathChoice) {
                if (realpath($this->path()) === realpath($this->basePath($pathChoice))) {
                    return $this->namespace = $namespace;
                }
            }
        }

        throw new RuntimeException('Unable to detect application namespace.');
    }
}
