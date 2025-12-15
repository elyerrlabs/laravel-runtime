<?php

namespace Elyerr\LaravelRuntime\Console;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Container\Container;
use Illuminate\Console\Events\ArtisanStarting;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Exception\CommandNotFoundException;
use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\Application as SymfonyApplication;

class Application extends \Illuminate\Console\Application
{
    /**
     * Commands allowed
     * @var array
     */
    protected $commands = [
        //  "help",
        //  "list",
        //  "_complete",
        //  "completion",
        "make:transformer",
        //   "api-response:install",
        //    "tinker",
        //   "about",
        //    "cache:clear",
        //    "cache:forget",
        //    "clear-compiled",
        //    "auth:clear-resets",
        //    "config:cache",
        //    "config:clear",
        //    "config:show",
        //    "db",
        //    "db:monitor",
        //    "model:prune",
        //   "db:show",
        //"db:table",
        //"db:wipe",
        //"down",
        //"env",
        //"env:decrypt",
        //"env:encrypt",
        //"event:cache",
        //"event:clear",
        //"event:list",
        //"invoke-serialized-closure",
        //"key:generate",
        //"optimize",
        //"optimize:clear",
        "package:discover",
        //"cache:prune-stale-tags",
        //"queue:clear",
        //"queue:failed",
        //"queue:flush",
        //"queue:forget",
        //"queue:listen",
        //"queue:monitor",
        //"queue:pause",
        //"queue:prune-batches",
        //"queue:prune-failed",
        //"queue:restart",
        //"queue:resume",
        //"queue:continue",
        //"queue:retry",
        //"queue:retry-batch",
        //"queue:work",
        //"reload",
        //"route:cache",
        //"route:clear",
        //"route:list",
        //"schema:dump",
        //"db:seed",
        //"schedule:finish",
        //"schedule:list",
        //"schedule:run",
        //"schedule:clear-cache",
        //"schedule:test",
        //"schedule:work",
        //"schedule:interrupt",
        //"model:show",
        //"storage:link",
        //"storage:unlink",
        //"up",
        //"view:cache",
        //"view:clear",
        // "install:api",
        // "install:broadcasting",
        // "make:cache-table",
        // "cache:table",
        "make:cast",
        // "channel:list",
        "make:channel",
        "make:class",
        "make:component",
        "make:config",
        // "config:make",
        // "config:publish",
        "make:command",
        "make:controller",
        //  "docs",
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
        // "make:notifications-table",
        // "notifications:table",
        "make:observer",
        "make:policy",
        "make:provider",
        // "make:queue-failed-table",
        //   "queue:failed-table",
        //   "make:queue-table",
        //  "queue:table",
        //   "make:queue-batches-table",
        //   "queue:batches-table",
        "make:request",
        "make:resource",
        "make:rule",
        "make:scope",
        "make:seeder",
        // "make:session-table",
        //   "session:table",
        //    "serve",
        //  "stub:publish",
        "make:test",
        "make:trait",
        //  "vendor:publish",
        "make:view",
        //  "migrate",
        //  "migrate:fresh",
        //  "migrate:install",
        //  "migrate:refresh",
        //  "migrate:reset",
        //  "migrate:rollback",
        //  "migrate:status",
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
