<?php

namespace Elyerr\LaravelRuntime\Command;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

#[AsCommand(name: 'assets:publish')]
class StorageLink extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'assets:publish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish public directory assets for the current module';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $modulePath = base_path('/');
        $rawModuleName = basename($modulePath);

        $moduleName = Str::of($rawModuleName)
            ->replace([',', '_'], ' ')
            ->snake()
            ->replace('_', '-')
            ->lower()
            ->toString();

        $target = public_path();
        $link = base_path("/../../public/third-party/{$moduleName}");

        if (!File::exists($target)) {
            $this->warn("No public assets found for module [{$moduleName}].");
            return Command::SUCCESS;
        }

        if (File::exists($link) || is_link($link)) {
            File::delete($link);
        }

        File::link($target, $link);

        $this->info("Assets published for module {$moduleName}.");

        return Command::SUCCESS;
    }
}
