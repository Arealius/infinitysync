<?php

namespace App\Domains\Engine\Services;

use App\Domains\Entity\Enums\EntityEnum;
use App\Helpers\Classes\Helper;
use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class GeminiService
{
    public array $history = [];

    public const ENDPOINT = 'https://generativelanguage.googleapis.com/v1beta/models/';

    public function streamGenerateContent($entity = EntityEnum::GEMINI_PRO->value): PromiseInterface|Response
    {
        Helper::setGeminiKey();

        $client = $this->client();
        $body = [
            'contents' => $this->getHistory(),
        ];

        $url = sprintf('%s%s:streamGenerateContent?key=%s', self::ENDPOINT, $entity, config('gemini.api_key'));

        return $client->withOptions(['stream' => true])->post($url, $body);
    }

    public function generateContent($entity = EntityEnum::GEMINI_PRO->value): PromiseInterface|Response
    {

        Helper::setGeminiKey();

        $client = $this->client();
        $body = [
            'contents' => $this->getHistory(),
        ];

        $url = sprintf('%s%s:generateContent?key=%s', self::ENDPOINT, $entity, config('gemini.api_key'));

        return $client->post($url, $body);
    }

    public function client(): PendingRequest
    {
        return Http::withHeaders([
            'Content-Type' => 'application/json',
        ]);
    }

    /**
     * Read a line from the stream.
     */
    public function readLine($stream): string
    {
        $buffer = '';

        while (! $stream->eof()) {
            $buffer .= $stream->read(1);

            if (strlen($buffer) === 1 && $buffer !== '{') {
                $buffer = '';
            }

            if (json_decode($buffer) !== null) {
                return $buffer;
            }
        }

        return rtrim($buffer, ']');
    }

    public function getHistory(): array
    {
        return $this->history;
    }

    public function setHistory(array $history): self
    {
        $this->history = $history;

        return $this;
    }
}
