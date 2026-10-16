<?php

/**
 * @package     Supertext Translation for Pimcore
 * @copyright   (C) Supertext AG
 * @license     MIT
 */

namespace Supertext\PimcoreTranslationBundle\Api;

use Supertext\PimcoreTranslationBundle\PluginHealth\Http\HttpRequest;
use Supertext\PimcoreTranslationBundle\PluginHealth\Http\HttpResponse;
use Supertext\PimcoreTranslationBundle\PluginHealth\Http\HttpTransport;
use Supertext\PimcoreTranslationBundle\PluginHealth\Http\TransportException;
use Supertext\PimcoreTranslationBundle\Sdk\Http\HttpRequest as SdkRequest;
use Supertext\PimcoreTranslationBundle\Sdk\Http\HttpTransport as SdkTransport;

/**
 * Sends Supertext Plugin Health's version reports through the bundle's SDK transport (Symfony
 * HttpClient, so Pimcore's proxy settings apply; a fake in tests). Both libraries have the same
 * HTTP shape; only the namespaces differ.
 */
final class ReportTransport implements HttpTransport
{
    public function __construct(private readonly SdkTransport $transport)
    {
    }

    public function send(HttpRequest $request): HttpResponse
    {
        try {
            $response = $this->transport->send(new SdkRequest($request->method, $request->url, $request->headers, $request->body, $request->timeout));
        } catch (\Throwable $e) {
            throw new TransportException($e->getMessage(), 0, $e);
        }

        return new HttpResponse($response->status, $response->body, $response->headers);
    }
}
