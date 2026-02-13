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
        $modulePath = base_path('');
        $rawModuleName = basename($modulePath);

        $moduleName = Str::of($rawModuleName)
            ->replace([',', '_'], ' ')
            ->snake()
            ->replace('_', '-')
            ->lower()
            ->toString();

        $target = public_path();
        $link = base_path("../../public/third-party/{$moduleName}");

        $this->info("Target: {$target}");
        $this->info("Link: {$link}");

        if (!File::exists($target)) {
            $this->warn("No public assets found for module [{$moduleName}].");
            return Command::SUCCESS;
        }

        $parentDir = dirname($link);
        if (!File::exists($parentDir)) {
            $this->warn("Creating parent directory for link: {$parentDir}");
            File::makeDirectory($parentDir, 0755, true);
        }

        if (File::exists($link) || is_link($link)) {
            $this->warn("Deleting existing link or file at: {$link}");
            File::delete($link);
        }

        try {
            File::link($target, $link);
            $this->info("Assets published for module {$moduleName}.");
        } catch (\Throwable $e) {
            $this->error("Failed to create symlink!");
            $this->error("Error: " . $e->getMessage());
            $this->error("Check that the parent directory exists and that the container user has permissions.");
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}
