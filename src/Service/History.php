<?php

declare(strict_types=1);

namespace Supertext\PimcoreTranslationBundle\Service;

use Pimcore\Model\Element\ElementInterface;
use Pimcore\Model\Element\Note;
use Pimcore\Model\Element\Service as ElementService;

/**
 * Supertext translations are recorded as notes on the element (type "supertext"), so they
 * show up in Studio's "Notes & Events" tab.
 */
final class History
{
    public const NOTE_TYPE = 'supertext';

    public function record(ElementInterface $element, string $source, string $target, ?int $userId, ?ElementInterface $translation = null): void
    {
        $note = new Note();
        $note->setElement($element);
        $note->setDate(time());
        $note->setType(self::NOTE_TYPE);
        $note->setTitle(sprintf('Translated with Supertext: %s → %s', $source, $target));
        $note->setDescription($translation
            ? sprintf('Saved as %s (ID %d), not yet published.', $translation->getFullPath(), $translation->getId())
            : 'Saved as a new version, not yet published.');
        $note->setUser((int) $userId);
        $note->addData('source', 'text', $source);
        $note->addData('target', 'text', $target);
        $note->save();
    }

    /** @return array<string, int> target language => timestamp of the last Supertext translation */
    public function lastTranslations(ElementInterface $element): array
    {
        $list = new Note\Listing();
        $list->setCondition('cid = ? AND ctype = ? AND type = ?', [
            $element->getId(),
            ElementService::getElementType($element),
            self::NOTE_TYPE,
        ]);
        $list->setOrderKey('date');
        $list->setOrder('ASC');
        $out = [];
        foreach ($list->load() as $note) {
            $target = $note->getData()['target']['data'] ?? null;
            if (\is_string($target) && $target !== '') {
                $out[$target] = $note->getDate();
            }
        }

        return $out;
    }
}
