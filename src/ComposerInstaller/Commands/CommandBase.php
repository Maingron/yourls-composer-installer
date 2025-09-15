<?php

declare(strict_types=1);

/**
 * YOURLS Composer Installer
 */

namespace YOURLS\ComposerInstaller\Commands;

use RuntimeException;
use Symfony\Component\Console\Output\OutputInterface;
use Composer\Command\BaseCommand;
use Composer\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;

/**
 * YOURLS Composer Installer
 *
 * @package   YOURLS\ComposerInstaller
 * @author    Ozh <ozh@ozh.org>
 * @link      https://github.com/yourls/composer-installer/
 * @license   MIT
 */
class CommandBase extends BaseCommand
{
    /**
     * Run a composer internal command
     *
     * @param array<string, mixed> $commandParams  Command parameters
     *
     * @throws RuntimeException
     */
    public function runComposerCommand(array $commandParams, OutputInterface $output): int
    {
        $application = new Application();
        $application->resetComposer();
        // Don't auto exit after command so we can chain several ones
        $application->setAutoExit(false);

        $input = new ArrayInput($commandParams);

        // Execute command and display its output
        $exitCode = $application->run($input, $output);

        if ($exitCode) {
            throw new RuntimeException(
                sprintf('Command "%s" failed', $commandParams['command'])
            );
        }

        return $exitCode;
    }
}
