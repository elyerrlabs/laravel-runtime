<?php
namespace Elyerr\LaravelRuntime\App;

use Elyerr\LaravelRuntime\Command\FactoryMakeCommand;
use RuntimeException;
use Elyerr\LaravelRuntime\App\ApplicationBuilder;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\ConsoleOutput;
use Illuminate\Contracts\Console\Kernel as ConsoleKernelContract;

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
            ->withCommands([
                \Elyerr\LaravelRuntime\Command\ModelMakeCommand::class,
                \Elyerr\LaravelRuntime\Command\SeederMakeCommand::class,
                \Elyerr\LaravelRuntime\Command\FactoryMakeCommand::class
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

