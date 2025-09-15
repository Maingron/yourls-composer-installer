<?php

declare(strict_types=1);

/**
 * YOURLS Composer Installer
 */

namespace YOURLS\ComposerInstaller;

use Composer\Composer;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;
use Composer\Plugin\Capable;

/**
 * YOURLS Composer Installer Plugin
 *
 * This class activates the plugin installer and registers the class that will add
 * custom commands
 *
 * @package   YOURLS\ComposerInstaller
 * @author    Ozh <ozh@ozh.org>
 * @link      https://github.com/yourls/composer-installer/
 * @license   MIT
 */
class Plugin implements PluginInterface, Capable
{
    /**
     * Register plugin installer with Composer
     */
    public function activate(Composer $composer, IOInterface $io): void
    {
        $installer = new PluginInstaller($io, $composer);
        $composer->getInstallationManager()->addInstaller($installer);
    }

    public function deactivate(Composer $composer, IOInterface $io): void
    {
        // No deactivation logic needed
    }

    public function uninstall(Composer $composer, IOInterface $io): void
    {
        // No uninstall logic needed
    }

    /**
     * @return array<string, string>
     */
    public function getCapabilities(): array
    {
        return [
            'Composer\Plugin\Capability\CommandProvider' => 'YOURLS\ComposerInstaller\CommandProvider',
        ];
    }
}
