<?php
namespace Elyerr\LaravelRuntime\App;

use Elyerr\LaravelRuntime\App\ApplicationBuilder;
use Symfony\Component\Console\Input\InputInterface;
use Illuminate\Contracts\Console\Kernel as ConsoleKernelContract;
use Symfony\Component\Console\Output\ConsoleOutput;

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
            ->withCommands()
            ->withProviders();
    }
}

