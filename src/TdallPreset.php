<?php

namespace Yhif\Tdall;

use Illuminate\Support\Arr;
use Laravel\Ui\Presets\Preset;
use Illuminate\Filesystem\Filesystem;

class TDallPreset extends Preset
{
    const NPM_PACKAGES_TO_ADD = [

        '@alpinejs/persist' => '^3.13',
        'alpinejs' => '^3.13',
        'autoprefixer' => '^10.4',
        'daisyui' => '^4.9',
        'postcss' => '^8.4',
        'tailwindcss' => '^3.4',
    ];

    const NPM_PACKAGES_TO_REMOVE = [
        'lodash',
        'axios',
    ];

    public static function install() : void
    {
        static::updatePackages();

        $filesystem = new Filesystem;
        $filesystem->deleteDirectory(resource_path('sass'));
        $filesystem->copyDirectory(__DIR__ . '/../stubs/default', base_path());
    }

    public static function installAuth()
    {
        $filesystem = new Filesystem();

        $filesystem->copyDirectory(__DIR__ . '/../stubs/auth', base_path());
    }

    protected static function updatePackageArray(array $packages)
    {
        return array_merge(
            static::NPM_PACKAGES_TO_ADD,
            Arr::except($packages, static::NPM_PACKAGES_TO_REMOVE)
        );
    }

    /**
     * Update the contents of a file with the logic of a given callback.
     */
    protected static function updateFile(string $path, callable $callback)
    {
        $originalFileContents = file_get_contents($path);
        $newFileContents = $callback($originalFileContents);
        file_put_contents($path, $newFileContents);
    }
}
