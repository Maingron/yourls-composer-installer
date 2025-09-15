<?php

declare(strict_types=1);

namespace YOURLS\ComposerInstaller;

use Composer\Downloader\DownloaderInterface;
use Composer\Package\PackageInterface;
use Composer\Util\Filesystem;

class MockDownloader implements DownloaderInterface
{
    protected Filesystem $filesystem;

    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    public function getInstallationSource(): string
    {
        return 'dist';
    }

    public function download(PackageInterface $package, string $path): void
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

    public function update(PackageInterface $initial, PackageInterface $target, string $path): void
    {
        $this->remove($initial, $path);
        $this->download($target, $path);
    }

    public function remove(PackageInterface $package, string $path): void
    {
        // not needed for testing
    }

    public function setOutputProgress(bool $outputProgress): void
    {
        // not needed for testing
    }
}
