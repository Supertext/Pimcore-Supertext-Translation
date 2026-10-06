<?php

declare(strict_types=1);

namespace App\Controller;

use Pimcore\Controller\FrontendController;
use Pimcore\Model\Document;
use Pimcore\Tool;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Demo pages: renders the document with a switcher to its published translations.
 */
class DefaultController extends FrontendController
{
    public function defaultAction(Request $request): Response
    {
        $document = $this->document;
        $current = (string) ($document->getProperty('language') ?: 'en');
        $translations = (new Document\Service())->getTranslations($document);
        $translations[$current] = $document->getId();

        $languages = [];
        foreach (Tool::getValidLanguages() as $code) {
            $target = isset($translations[$code]) ? Document::getById((int) $translations[$code]) : null;
            if ($code !== $current && (!$target || !$target->isPublished())) {
                continue;
            }
            $languages[] = [
                'url' => $target?->getFullPath() ?? $document->getFullPath(),
                'label' => strtoupper(explode('_', $code)[0]),
                'hreflang' => str_replace('_', '-', $code),
                'current' => $code === $current,
            ];
        }

        return $this->render('default/default.html.twig', ['languages' => $languages]);
    }
}
