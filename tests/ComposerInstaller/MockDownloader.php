<?php

declare(strict_types=1);

namespace YOURLS\ComposerInstaller;

use Composer\Downloader\DownloaderInterface;
use Composer\Package\PackageInterface;
use Composer\Util\Filesystem;
use React\Promise\PromiseInterface;

class MockDownloader implements DownloaderInterface
{
    public function __construct(protected Filesystem $filesystem)
    {
    }

    public function getInstallationSource(): string
    {
        return 'dist';
    }

    public function download(PackageInterface $package, string $path, ?PackageInterface $prevPackage = null): PromiseInterface
    {
        // Simulate immediate resolution
        $this->installFiles($package, $path);
        return \React\Promise\resolve();
    }

    public function prepare(string $type, PackageInterface $package, string $path, ?PackageInterface $prevPackage = null): PromiseInterface
    {
        return \React\Promise\resolve();
    }

    public function install(PackageInterface $package, string $path): PromiseInterface
    {
        return $this->download($package, $path);
    }

    public function update(PackageInterface $initial, PackageInterface $target, string $path): PromiseInterface
    {
        $this->installFiles($target, $path);
        return \React\Promise\resolve();
    }

    public function remove(PackageInterface $package, string $path): PromiseInterface
    {
        return \React\Promise\resolve();
    }

    public function cleanup(string $type, PackageInterface $package, string $path, ?PackageInterface $prevPackage = null): PromiseInterface
    {
        return \React\Promise\resolve();
    }

    private function installFiles(PackageInterface $package, string $path): void
    {
        // install a fake plugin directory
        $this->filesystem->ensureDirectoryExists($path);
        touch($path . '/plugin.php');

        // create a vendor dir if requested by the test
        if (!empty($package->getExtra()['with-vendor-dir'])) {
            $this->filesystem->ensureDirectoryExists($path . '/vendor/test');
            touch($path . '/vendor/test/test.txt');
            touch($path . '/vendor-created.txt');
        }
    }

    public function setOutputProgress(bool $outputProgress): void
    {
        // not needed for testing
    }
}
