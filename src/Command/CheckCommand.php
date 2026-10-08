<?php

declare(strict_types=1);

namespace Supertext\PimcoreTranslationBundle\Command;

use Supertext\PimcoreTranslationBundle\Api\SupertextException;
use Supertext\PimcoreTranslationBundle\Settings;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * bin/console supertext:check: shows the API address and checks the API key (cost-free).
 */
#[AsCommand(name: 'supertext:check', description: 'Checks the Supertext API key (no cost).')]
final class CheckCommand extends Command
{
    public function __construct(private readonly Settings $settings)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('API address: ' . $this->settings->baseUrl());
        if ($this->settings->apiKey() === '') {
            $output->writeln('<error>No API key. Set the SUPERTEXT_API_KEY environment variable.</error>');
            $output->writeln(Settings::KEY_HELP);

            return Command::FAILURE;
        }
        try {
            $this->settings->client()->validateApiKey();
        } catch (SupertextException $e) {
            $output->writeln('<error>' . Settings::withKeyHelp($e)->getMessage() . '</error>');

            return Command::FAILURE;
        }
        $output->writeln('<info>Connected. The API key works.</info>');

        return Command::SUCCESS;
    }
}
