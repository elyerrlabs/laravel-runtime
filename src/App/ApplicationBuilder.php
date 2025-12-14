<?php
namespace Elyerr\LaravelRuntime\App;

use Illuminate\Foundation\Application;

class ApplicationBuilder extends \Illuminate\Foundation\Configuration\ApplicationBuilder
{
    /**
     * Create a new application builder instance.
     */
    public function __construct(protected Application $app)
    {
        
    }

    /**
     * Register the standard kernel classes for the application.
     *
     * @return $this
     */
    public function withKernels()
    {
        $this->app->singleton(
            \Illuminate\Contracts\Http\Kernel::class,
            \Illuminate\Foundation\Http\Kernel::class,
        );

        $this->app->singleton(
            \Illuminate\Contracts\Console\Kernel::class,
            \Elyerr\LaravelRuntime\Console\Kernel::class,
        );

        return $this;
    }
}
