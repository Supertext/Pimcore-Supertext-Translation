<?php

/**
 * @package     Supertext Translation for Pimcore
 * @copyright   (C) Supertext AG
 * @license     MIT
 */

namespace Supertext\PimcoreTranslationBundle\Api;

use Supertext\PimcoreTranslationBundle\Sdk\Http\HttpRequest;
use Supertext\PimcoreTranslationBundle\Sdk\Http\HttpResponse;
use Supertext\PimcoreTranslationBundle\Sdk\Http\HttpTransport;
use Supertext\PimcoreTranslationBundle\Sdk\Http\TransportException;

/**
 * Sends the Supertext SDK's requests through a callable: Symfony HttpClient in the
 * bundle (so Pimcore's proxy settings apply), a fake in tests. Every HTTP answer, 4xx and
 * 5xx included, goes back to the SDK; only a missing answer is an exception.
 */
final class CallableTransport implements HttpTransport
{
    /** @var callable(string, string, array<string, string>, ?string, float): array{status: int, body: string, headers?: array<string, string>} */
    private $send;

    /**
     * @param callable(string $method, string $url, array<string, string> $headers, ?string $body, float $timeout): array{status: int, body: string, headers?: array<string, string>} $send
     *        $timeout: seconds for the whole request (3 s for version reports, 10 s for the key check)
     */
    public function __construct(callable $send)
    {
        $this->send = $send;
    }

    public function send(HttpRequest $request): HttpResponse
    {
        try {
            $response = ($this->send)($request->method, $request->url, $request->headers, $request->body, $request->timeout);
        } catch (\Throwable $e) {
            throw new TransportException($e->getMessage(), 0, $e);
        }

        return new HttpResponse($response['status'], $response['body'], $response['headers'] ?? []);
    }
}
