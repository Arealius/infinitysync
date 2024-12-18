<?php

declare(strict_types=1);

namespace App\Domains\Engine\Services;

use App\Domains\Entity\Enums\EntityEnum;
use App\Helpers\Classes\Helper;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class FalAIService
{
    public const GENERATE_ENDPOINT = 'https://queue.fal.run/fal-ai/%s';

    public const CHECK_ENDPOINT = 'https://queue.fal.run/fal-ai/%s/requests/%s';

    public const RUNWAY_URL = 'https://queue.fal.run/fal-ai/runway-gen3/turbo/image-to-video';

    public const KLING_URL = 'https://queue.fal.run/fal-ai/kling-video/v1/standard/text-to-video';

    public const LUMA_URL = 'https://queue.fal.run/fal-ai/luma-dream-machine';

    public const MINIMAX_URL = 'https://queue.fal.run/fal-ai/minimax-video';

    public static function generate($prompt, ?EntityEnum $entity = EntityEnum::FLUX_PRO)
    {
        $entityValue = (setting('fal_ai_default_model') ?: $entity?->value);

        $http = Http::withHeaders([
            'Content-Type'  => 'application/json',
            'Accept'        => 'application/json',
            'Authorization' => 'Key ' . Helper::setFalAIKey(),
        ])->post(sprintf(self::GENERATE_ENDPOINT, $entityValue), [
            'prompt' => $prompt,
        ]);

        if (($http->status() === 200) && $requestId = $http->json('request_id')) {
            return $requestId;
        }

        $detail = $http->json('detail');

        throw new RuntimeException(__($detail ?: 'Check your FAL API key.'));
    }

    public static function check($uuid, EntityEnum $entity = EntityEnum::FLUX_PRO): ?array
    {
        $entityValue = (setting('fal_ai_default_model') ?: $entity->value);
        $url = sprintf(self::CHECK_ENDPOINT, $entityValue, $uuid);

        $http = Http::withHeaders([
            'Content-Type'  => 'application/json',
            'Accept'        => 'application/json',
            'Authorization' => 'Key ' . Helper::setFalAIKey(),
        ])->get($url);

        if (($images = $http->json('images')) && is_array($images)) {
            $image = Arr::first($images);

            return [
                'image' => $image,
                'size'  => data_get($image, 'width') . 'x' . data_get($image, 'height'),
            ];
        }

        return null;
    }

    public static function runwayGenerate(string $prompt, string $imageUrl)
    {
        $response = Http::withHeaders([
            'Content-Type'  => 'application/json',
            'Accept'        => 'application/json',
            'Authorization' => 'Key ' . Helper::setFalAIKey(),
        ])
            ->post(self::RUNWAY_URL,
                [
                    'prompt'    => $prompt,
                    'image_url' => $imageUrl,
                ]);

        return $response->json();
    }

    public static function minimaxGenerate(string $prompt)
    {
        $response = Http::withHeaders([
            'Content-Type'  => 'application/json',
            'Accept'        => 'application/json',
            'Authorization' => 'Key ' . Helper::setFalAIKey(),
        ])
            ->post(self::MINIMAX_URL,
                [
                    'prompt' => $prompt,
                ]);

        return $response->json();
    }

    public static function klingGenerate(string $prompt)
    {
        $response = Http::withHeaders([
            'Content-Type'  => 'application/json',
            'Accept'        => 'application/json',
            'Authorization' => 'Key ' . Helper::setFalAIKey(),
        ])
            ->post(self::KLING_URL,
                [
                    'prompt' => $prompt,
                ]);

        return $response->json();
    }

    public static function lumaGenerate(string $prompt)
    {
        $response = Http::withHeaders([
            'Content-Type'  => 'application/json',
            'Accept'        => 'application/json',
            'Authorization' => 'Key ' . Helper::setFalAIKey(),
        ])
            ->post(self::LUMA_URL,
                [
                    'prompt' => $prompt,
                ]);

        return $response->json();
    }

    public static function getStatus($url)
    {
        $response = Http::withHeaders([
            'Content-Type'  => 'application/json',
            'Accept'        => 'application/json',
            'Authorization' => 'Key ' . Helper::setFalAIKey(),
        ])
            ->get($url);

        return $response->json();
    }
}
