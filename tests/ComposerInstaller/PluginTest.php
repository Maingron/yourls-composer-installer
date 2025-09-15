<?php

declare(strict_types=1);

namespace YOURLS\ComposerInstaller;

use PHPUnit\Framework\TestCase;

use Composer\Composer;
use Composer\Config;
use Composer\Installer\InstallationManager;
use Composer\IO\NullIO;

class PluginTest extends TestCase
{
    /**
     * Test if the composer plugin loads as expected
     */
    public function testActivate(): void
    {
        $composer            = new Composer();
        $io                  = new NullIO();
        $loop                = new \Composer\Util\Loop(new \Composer\Util\HttpDownloader($io, new Config()));
        $installationManager = new InstallationManager($loop, $io);
        $composer->setInstallationManager($installationManager);
        $composer->setConfig(new Config());

        $plugin = new Plugin();
        $plugin->activate($composer, $io);

        $installer = $installationManager->getInstaller('yourls-plugin');
        $this->assertInstanceOf(PluginInstaller::class, $installer);
    }

    public function testCapabilities(): void
    {
        $plugin = new Plugin();

        $this->assertSame(
            ['Composer\Plugin\Capability\CommandProvider' => 'YOURLS\ComposerInstaller\CommandProvider'],
            $plugin->getCapabilities()
        );
    }
}
