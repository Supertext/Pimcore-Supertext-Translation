<?php

declare(strict_types=1);

namespace Supertext\PimcoreTranslationBundle\Command;

use Pimcore\Model\DataObject\Concrete;
use Pimcore\Model\Document;
use Pimcore\Model\Document\PageSnippet;
use Pimcore\Model\User;
use Pimcore\Tool;
use Supertext\PimcoreTranslationBundle\Api\SupertextException;
use Supertext\PimcoreTranslationBundle\Service\DocumentTranslator;
use Supertext\PimcoreTranslationBundle\Service\ObjectTranslator;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * bin/console supertext:translate --document=<id|path> | --object=<id|path> [--from=en] [--to=de_CH,fr_CH] [--overwrite] [--user=<name>]
 */
#[AsCommand(name: 'supertext:translate', description: 'Translates a document or data object with Supertext.')]
final class TranslateCommand extends Command
{
    public function __construct(
        private readonly DocumentTranslator $documents,
        private readonly ObjectTranslator $objects,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addOption('document', null, InputOption::VALUE_REQUIRED, 'Document ID or path')
            ->addOption('object', null, InputOption::VALUE_REQUIRED, 'Data object ID or path')
            ->addOption('from', null, InputOption::VALUE_REQUIRED, 'Source language of a data object (default: the first language); documents use their "language" property')
            ->addOption('to', null, InputOption::VALUE_REQUIRED, 'Target languages, comma separated (default: all others)')
            ->addOption('overwrite', null, InputOption::VALUE_NONE, 'Replace translations that already exist')
            ->addOption('user', null, InputOption::VALUE_REQUIRED, 'Translate as this Pimcore user (default: the first active administrator)');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $user = $this->user($input->getOption('user'));
        if (!$user) {
            $output->writeln('<error>User not found.</error>');

            return Command::FAILURE;
        }
        $documentRef = $input->getOption('document');
        $objectRef = $input->getOption('object');
        $element = null;
        if ($documentRef !== null) {
            $element = ctype_digit((string) $documentRef) ? Document::getById((int) $documentRef) : Document::getByPath((string) $documentRef);
            $element = $element instanceof PageSnippet ? $element : null;
        } elseif ($objectRef !== null) {
            $element = ctype_digit((string) $objectRef) ? Concrete::getById((int) $objectRef) : Concrete::getByPath((string) $objectRef);
            $element = $element instanceof Concrete ? $element : null;
        }
        if (!$element) {
            $output->writeln('<error>Not found. Use --document=<id|path> (a page or snippet) or --object=<id|path>.</error>');

            return Command::FAILURE;
        }

        $source = $element instanceof PageSnippet
            ? $this->documents->language($element)
            : ((string) $input->getOption('from') ?: (Tool::getValidLanguages()[0] ?? ''));
        $targets = array_values(array_filter(array_map('trim', explode(',', (string) $input->getOption('to')))));
        if ($targets === []) {
            $targets = array_values(array_diff(Tool::getValidLanguages(), [$source]));
        }
        $overwrite = (bool) $input->getOption('overwrite');

        try {
            $results = $element instanceof PageSnippet
                ? $this->documents->translate($element, $targets, $overwrite, $user)
                : $this->objects->translate($element, $source, $targets, $overwrite, $user);
        } catch (SupertextException $e) {
            $output->writeln('<error>' . $e->getMessage() . '</error>');

            return Command::FAILURE;
        }

        $failed = false;
        foreach ($results as $r) {
            $line = $r['language'] . ': ' . $r['status']
                . (isset($r['path']) ? ' ' . $r['path'] : '')
                . ($r['message'] !== '' ? " ({$r['message']})" : '');
            $failed = $failed || $r['status'] === 'error';
            $output->writeln($r['status'] === 'error' ? "<error>{$line}</error>" : $line);
        }

        return $failed ? Command::FAILURE : Command::SUCCESS;
    }

    private function user(?string $name): ?User
    {
        if ($name !== null && $name !== '') {
            $user = User::getByName($name);

            return $user instanceof User ? $user : null;
        }
        $list = new User\Listing();
        $list->setCondition('`admin` = 1 AND `active` = 1');
        $list->setOrderKey('id');
        $list->setLimit(1);

        return $list->load()[0] ?? null;
    }
}
