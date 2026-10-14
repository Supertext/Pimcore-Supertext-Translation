<?php

declare(strict_types=1);

namespace Supertext\PimcoreTranslationBundle\Ping;

use Supertext\PimcoreTranslationBundle\Reporting\Reporting;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

/**
 * GET /supertext/ping?challenge=<c>: the public endpoint the Supertext Commando Center calls to see
 * that the site is reachable. No login, no session, outside Studio's firewall; the answer says
 * `Cache-Control: no-store`, so Pimcore's full page cache doesn't keep it. 404 while version reports
 * are off. Status, headers and body come from the SDK (InstallationReporter::pingResponse()).
 */
final class PingController
{
    public function __construct(private readonly Reporting $reporting)
    {
    }

    #[Route('/supertext/ping', name: 'supertext_translation_ping', methods: ['GET'])]
    public function ping(Request $request): Response
    {
        $ping = $this->reporting->ping($request->query->get('challenge'));
        $response = new Response($ping->body, $ping->status);
        foreach ($ping->headers as $name => $value) {
            $response->headers->set($name, $value);
        }

        return $response;
    }
}
