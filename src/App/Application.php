<?php
namespace Elyerr\LaravelRuntime\App;

use RuntimeException;
use Illuminate\Support\Composer;
use Illuminate\Filesystem\Filesystem;
use Elyerr\LaravelRuntime\App\ApplicationBuilder;
use Elyerr\LaravelRuntime\Providers\ServiceProvider;
use Illuminate\Database\Migrations\MigrationCreator;

class Application extends \Illuminate\Foundation\Application
{
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
                \Elyerr\LaravelRuntime\Command\StorageLink::class,
                \Elyerr\LaravelRuntime\Command\MigrateMakeCommand::class,
            ])
            ->withProviders();
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

