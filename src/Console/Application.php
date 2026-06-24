<?php

namespace Elyerr\LaravelRuntime\Console;

class Application extends \Illuminate\Console\Application
{
    /**
     * Commands allowed
     * @var array
     */
    protected $commands = [
        "make:transformer",
        "package:discover",
        "make:cast",
        "make:channel",
        "make:class",
        "make:component",
        "make:config",
        "make:command",
        "make:controller",
        "make:enum",
        "event:generate",
        "make:event",
        "make:exception",
        "make:factory",
        "make:interface",
        "make:job",
        "make:job-middleware",
        "lang:publish",
        "make:listener",
        "make:mail",
        "make:middleware",
        "make:model",
        "make:notification",
        "make:observer",
        "make:policy",
        "make:provider",
        "make:request",
        "make:resource",
        "make:rule",
        "make:scope",
        "make:seeder",
        "make:test",
        "make:trait",
        "make:view",
        "make:migration",
    ];


    /**
     * Set the container command loader for lazy resolution.
     *
     * @return $this
     */
    public function setContainerCommandLoader()
    {
        // Filter only command allowed
        $this->commandMap = array_intersect_key($this->commandMap, array_flip($this->commands));

        // Loader for commands
        $this->setCommandLoader(new \Illuminate\Console\ContainerCommandLoader($this->laravel, $this->commandMap));

        return $this;
    }
}
