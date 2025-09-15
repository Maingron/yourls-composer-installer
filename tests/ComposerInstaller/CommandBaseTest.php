<?php

declare(strict_types=1);

namespace YOURLS\ComposerInstaller;

use PHPUnit\Framework\TestCase;
use Composer\Command\BaseCommand;
use YOURLS\ComposerInstaller\Commands\CommandBase;
use Symfony\Component\Console\Output\OutputInterface;
use RuntimeException;

class CommandBaseTest extends TestCase
{
    protected OutputInterface $output;

    /**
     * SetUp: create mock of OutputInterface
     */
    protected function setUp(): void
    {
        $this->output = $this->createMock(OutputInterface::class);
    }

    /**
     * Test invalid command
     */
    public function testrunInvalidCommand(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Command "omglol" failed');
        $plugin = new CommandBase();
        $test = $plugin->runComposerCommand(['command' => 'omglol'], $this->output);
    }

    /**
     * Test empty command returns 0 (ie no error)
     */
    public function testrunComposerCommand(): void
    {
        $plugin = new CommandBase();
        $test = $plugin->runComposerCommand([], $this->output);
        $this->assertSame(0, $test);
    }
}
