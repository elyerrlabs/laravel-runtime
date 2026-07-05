<?php

namespace Elyerr\LaravelRuntime\App;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Env;

final class PackageManifest extends \Illuminate\Foundation\PackageManifest
{

    /**
     * Construct
     * @param Filesystem $files
     * @param mixed $basePath
     * @param mixed $manifestPath
     */
    public function __construct(Filesystem $files, $basePath, $manifestPath)
    {
        $vendorModule = $basePath . '/vendor-build';
        $this->files = $files;
        $this->basePath = $basePath;
        $this->manifestPath = $manifestPath;
        $this->vendorPath = is_dir($vendorModule) ? $vendorModule : (Env::get('COMPOSER_VENDOR_DIR') ?: $basePath . '/vendor');
    }
}
