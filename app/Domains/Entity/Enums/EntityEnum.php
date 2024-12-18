<?php

declare(strict_types=1);

namespace App\Domains\Entity\Enums;

use App\Domains\Engine\Enums\EngineEnum;
use App\Domains\Entity\Contracts\Calculate\WithCharsInterface;
use App\Domains\Entity\Contracts\Calculate\WithImagesInterface;
use App\Domains\Entity\Contracts\Calculate\WithImageToVideoInterface;
use App\Domains\Entity\Contracts\Calculate\WithPlagiarismInterface;
use App\Domains\Entity\Contracts\Calculate\WithSpeechToTextInterface;
use App\Domains\Entity\Contracts\Calculate\WithTextToSpeechInterface;
use App\Domains\Entity\Contracts\Calculate\WithTextToVideoInterface;
use App\Domains\Entity\Contracts\Calculate\WithVisionPreviewInterface;
use App\Domains\Entity\Contracts\Calculate\WithWordsInterface;
use App\Domains\Entity\Drivers\Anthropic;
use App\Domains\Entity\Drivers\AzureDriver;
use App\Domains\Entity\Drivers\ClipDropDriver;
use App\Domains\Entity\Drivers\ElevenLabs;
use App\Domains\Entity\Drivers\FalAI;
use App\Domains\Entity\Drivers\Gemini;
use App\Domains\Entity\Drivers\GoogleDriver;
use App\Domains\Entity\Drivers\HeygenDriver;
use App\Domains\Entity\Drivers\OpenAI;
use App\Domains\Entity\Drivers\PebblelyDriver;
use App\Domains\Entity\Drivers\PexelsDriver;
use App\Domains\Entity\Drivers\PixabayDriver;
use App\Domains\Entity\Drivers\PlagiarismCheckDriver;
use App\Domains\Entity\Drivers\SerperDriver;
use App\Domains\Entity\Drivers\StableDiffusion;
use App\Domains\Entity\Drivers\SynthesiaDriver;
use App\Domains\Entity\Drivers\UnsplashDriver;
use App\Enums\AITokenType;
use App\Enums\Traits\EnumTo;
use App\Enums\Traits\SluggableEnumTrait;
use App\Enums\Traits\StringBackedEnumTrait;
use Illuminate\Support\Collection;

enum EntityEnum: string
{
    use EnumTo;
    use SluggableEnumTrait;
    use StringBackedEnumTrait;

    // Anthropic
    case CLAUDE_3_5_SONNET = 'claude-3-5-sonnet-20240620';

    case CLAUDE_3_SONNET = 'claude-3-sonnet-20240229';

    case CLAUDE_3_OPUS = 'claude-3-opus-20240229';

    case CLAUDE_3_HAIKU = 'claude-3-haiku-20240307';

    case CLAUDE_2_1 = 'claude-2.1';

    case CLAUDE_2_0 = 'claude-2.0';

    // Embeding models for Anthropic
    case VOYAGE_2 = 'voyage-2';

    case VOYAGE_LARGE_2 = 'voyage-large-2';

    case VOYAGE_CODE_2 = 'voyage-code-2';
    // OpenAI
    case DAVINCI = 'davinci-002';

    case GPT_3_5_TURBO_16K = 'gpt-3.5-turbo-16k';

    case GPT_3_5_TURBO = 'gpt-3.5-turbo';

    case GPT_3_5_TURBO_0125 = 'gpt-3.5-turbo-0125';

    case GPT_3_5_TURBO_1106 = 'gpt-3.5-turbo-1106';

    case GPT_4 = 'gpt-4';

    case GPT_4_TURBO = 'gpt-4-turbo';

    case GPT_4_1106_PREVIEW = 'gpt-4-1106-preview';

    case GPT_4_0125_PREVIEW = 'gpt-4-0125-preview';

    case GPT_4_VISION_PREVIEW = 'gpt-4-vision-preview';

    case GPT_4_O = 'gpt-4o';

    case GPT_4_O_MINI = 'gpt-4o-mini';

    case GPT_4_O1_PREVIEW = 'o1-preview';

    case GPT_4_O1_MINI = 'o1-mini';

    case TEXT_DAVINCI_003 = 'text-davinci-003';

    // embeding models for openai
    case TEXT_EMBEDDING_ADA_002 = 'text-embedding-ada-002';

    case TEXT_EMBEDDING_3_SMALL = 'text-embedding-3-small';

    case TEXT_EMBEDDING_3_LARGE = 'text-embedding-3-large';

    // Stable Diffusion
    case IMAGE_TO_VIDEO = 'image-to-video';

    case STABLE_DIFFUSION_XL_1024_V_1_0 = 'stable-diffusion-xl-1024-v1-0';

    case STABLE_DIFFUSION_V_1_6 = 'stable-diffusion-v1-6';

    case SD_3 = 'sd3';

    case SD_3_TURBO = 'sd3-turbo';

    case SD_3_MEDIUM = 'sd3-medium';

    case SD_3_LARGE = 'sd3-large';

    case SD_3_LARGE_TURBO = 'sd3-large-turbo';

    case SD_3_5_LARGE = 'sd3.5-large';

    case SD_3_5_LARGE_TURBO = 'sd3.5-large-turbo';

    case SD_3_5_MEDIUM = 'sd3.5-medium';

    case CORE = 'core';

    case ULTRA = 'ultra';

    case AWS_BEDROCK = 'aws_bedrock';

    case CLIPDROP = 'clipdrop';

    case PLAGIARISMCHECK = 'plagiarismcheck';

    case SYNTHESIA = 'synthesia';

    case HEYGEN = 'heygen';

    case PEBBLELY = 'pebblely';

    case GEMINI_TEXT_EMBEDING_004 = 'text-embedding-004';

    case GEMINI_1_5_PRO_LATEST = 'gemini-1.5-pro-latest';

    case GEMINI_PRO = 'gemini-pro';

    case GEMINI_1_5_FLASH = 'gemini-1.5-flash';

    case GEMINI_PRO_VISION = 'gemini-pro-vision';

    case UNSPLASH = 'unsplash';

    case PEXELS = 'pexels';

    case PIXABAY = 'pixabay';

    case ELEVENLABS = 'elevenlabs';

    case ISOLATOR = 'isolator';

    case GOOGLE = 'google';

    case AZURE = 'azure';

    case SERPER = 'serper';

    case WHISPER_1 = 'whisper-1';

    case DALL_E_2 = 'dall-e-2';

    case DALL_E_3 = 'dall-e-3';

    case TTS_1 = 'tts-1';

    case TTS_1_HD = 'tts-1-hd';

    case FLUX_PRO = 'flux-pro';

    case FLUX_PRO_1_1 = 'flux-pro/v1.1';

    case FLUX_REALISM = 'flux-realism';

    case FLUX_SCHNELL = 'flux/schnell';

    case KLING = 'kling';

    case LUMA_DREAM_MACHINE = 'luma-dream-machine';

    case RUNWAY_GEN3 = 'runway-gen3';

    case MINIMAX = 'minimax';

    public static function listableCases(): Collection
    {
        return collect(self::cases())->map(
            fn ($case) => $case->creditBy()
        )->unique()->values();
    }

    public function creditBy(): self
    {
        // we are not using this for now, because we only show default model for user
        return match ($this) {
            // self::GPT_3_5_TURBO_0125,
            // self::GPT_3_5_TURBO_1106,
            // self::GPT_3_5_TURBO_16K  => self::GPT_3_5_TURBO,
            // self::GPT_4_0125_PREVIEW,
            // self::GPT_4_1106_PREVIEW => self::GPT_4_VISION_PREVIEW,
            default                  => $this
        };
    }

    public function creditIndex(): float
    {
        return 1.0;
    }

    public function label(): string
    {
        return match ($this) {
            self::IMAGE_TO_VIDEO                    => __('AI Video'),
            self::STABLE_DIFFUSION_XL_1024_V_1_0    => __('Stable Diffusion XL 1.0'),
            self::STABLE_DIFFUSION_V_1_6            => __('Stable Diffusion 1.6'),
            self::SD_3                              => __('Stable Diffusion 3'),
            self::SD_3_TURBO                        => __('Stable Diffusion 3 turbo'),
            self::SD_3_MEDIUM                       => __('Stable Diffusion 3 Medium'),
            self::SD_3_LARGE                        => __('Stable Diffusion 3 Large'),
            self::SD_3_LARGE_TURBO                  => __('Stable Diffusion 3 Large Turbo'),
            self::SD_3_5_LARGE                      => __('Stable Diffusion 3.5 Large'),
            self::SD_3_5_LARGE_TURBO                => __('Stable Diffusion 3.5 Large Turbo'),
            self::SD_3_5_MEDIUM                     => __('Stable Diffusion 3.5 Medium'),
            self::CORE                              => __('Core'),
            self::ULTRA                             => __('Ultra'),
            self::AWS_BEDROCK                       => __('AWS Bedrock'),
            // OpenAI
            self::DAVINCI                => __('Davinci (Expensive &amp; Capable)'),
            self::GPT_3_5_TURBO_16K      => __('GTP (3.5-turbo-16k)'),
            self::GPT_3_5_TURBO          => __('GPT 3.5-turbo (Most Expensive & Fastest & Most Capable)'),
            self::GPT_3_5_TURBO_0125     => __('GTP 3.5-turbo-0125 (Updated Knowleddge cutoff of Sep 2021, 16k)'),
            self::GPT_3_5_TURBO_1106     => __('GTP 3.5-turbo-1106 (Updated Knowleddge cutoff of Nov 2021, 16k)'),
            self::GPT_4_TURBO            => __('GPT-4 Turbo (Most Expensive & Fastest & Most Capable)'),
            self::GPT_4                  => __('GPT-4 (Most Expensive & Fastest & Most Capable)'),
            self::GPT_4_1106_PREVIEW     => __('GPT-4-1106 Turbo (Updated Knowleddge cutoff of April 2023, 128k)'),
            self::GPT_4_0125_PREVIEW     => __('GPT-4-0125 Turbo (Updated Knowleddge cutoff of Dec 2023, 128k)'),
            self::GPT_4_VISION_PREVIEW   => __('GPT-4 Turbo with vision (Understand images, in addition to all other GPT-4 Turbo capabilites)'),
            self::TEXT_DAVINCI_003       => __('Text Davinci (Expensive &amp; Capable)'),
            self::TEXT_EMBEDDING_ADA_002 => __('Text Embedding Ada (Expensive &amp; Capable)'),
            self::TEXT_EMBEDDING_3_SMALL => __('Text Embedding Small'),
            self::TEXT_EMBEDDING_3_LARGE => __('Text Embedding Large'),
            self::WHISPER_1              => __('WHISPER 1 The latest text to speech model, optimized for speed.'),
            self::DALL_E_2               => __('DALL-E 2 The previous DALL·E model released in Nov 2022.'),
            self::DALL_E_3               => __('DALL-E 3 The latest DALL·E model released in Nov 2023.'),
            self::TTS_1                  => __('TTS 1 The latest text to speech model, optimized for speed.'),
            self::TTS_1_HD               => __('TTS 1 HD The latest text to speech model, optimized for quality.'),
            self::GPT_4_O                => __('GPT-4o Most advanced, multimodal flagship model that’s cheaper and faster than GPT-4 Turbo.  (Updated Knowleddge cutoff of Oct 2023, 128k)'),
            self::GPT_4_O_MINI           => __('GPT-4o mini Our affordable and intelligent small model for fast, lightweight tasks. GPT-4o mini is cheaper and more capable than GPT-3.5 Turbo.'),
            self::GPT_4_O1_PREVIEW       => __('GPT o1-preview (Updated Knowledge cutoff of Dec 2023, 128k)'),
            self::GPT_4_O1_MINI          => __('GPT o1-mini (Updated Knowledge cutoff of Dec 2023, 128k)'),
            // Anthropic
            self::CLAUDE_3_5_SONNET        => __('Claude 3.5 Sonnet'),
            self::CLAUDE_3_SONNET          => __('Claude 3 Sonnet'),
            self::CLAUDE_3_OPUS            => __('Claude 3 Opus'),
            self::CLAUDE_3_HAIKU           => __('Claude 3 Haiku'),
            self::CLAUDE_2_1               => __('Claude 2.1'),
            self::CLAUDE_2_0               => __('Claude 2'),
            self::VOYAGE_2                 => __('Voyage 2'),
            self::VOYAGE_LARGE_2           => __('Voyage Large 2'),
            self::VOYAGE_CODE_2            => __('Voyage Code 2'),
            self::CLIPDROP                 => __('Clipdrop for Photo Studio'),
            self::PLAGIARISMCHECK          => __('Plagiarism Check'),
            self::SYNTHESIA                => __('Synthesia'),
            self::HEYGEN                   => __('Heygen'),
            self::PEBBLELY                 => __('Pebblely'),
            self::GEMINI_TEXT_EMBEDING_004 => __('Gemini Text Embeding 004'),
            self::GEMINI_1_5_PRO_LATEST    => __('Gemini 1.5 Pro (Preview only) (Model last updated: April 2024)'),
            self::GEMINI_PRO               => __('Gemini 1.0 Pro (Model last updated: February 2024)'),
            self::GEMINI_1_5_FLASH         => __('Gemini 1.0 Pro Vision (Model last updated: February 2023)'),
            self::GEMINI_PRO_VISION        => __('Gemini Pro Vision'),
            // Unsplash
            self::UNSPLASH => __('Unsplash for AI Article Wizard'),
            // Pexels
            self::PEXELS => __('Pexels for AI Article Wizard'),
            // Pixabay
            self::PIXABAY => __('Pixabay for AI Article Wizard'),
            // Elevenlabs
            self::ELEVENLABS => __('Elevenlabs for TTS'),
            self::ISOLATOR   => __('Voice Isolator (1 word = 5 used characters of elevenlabs) X 1 token'),
            // Google
            self::GOOGLE => __('Google for TTS'),
            // Azure
            self::AZURE => __('Azure for TTS'),
            // Serper
            self::SERPER => __('Serper for Realtime Data'),
            // FAL AI
            self::FLUX_PRO                 => __('Flux Pro'),
            self::FLUX_PRO_1_1             => __('Flux Pro 1.1'),
            self::FLUX_REALISM             => __('Flux Realism'),
            self::FLUX_SCHNELL             => __('Flux Schnell'),
            self::KLING                    => __('Kling 1.0'),
            self::LUMA_DREAM_MACHINE       => __('Luma Dream Machine'),
            self::RUNWAY_GEN3              => __('Runway Gen3'),
            self::MINIMAX                  => __('Minimax'),
        };
    }

    public function isV2BetaSdEntity(): bool
    {
        return match ($this) {
            self::SD_3,
            self::SD_3_TURBO,
            self::SD_3_MEDIUM,
            self::SD_3_LARGE,
            self::SD_3_LARGE_TURBO,
            self::SD_3_5_LARGE,
            self::SD_3_5_LARGE_TURBO,
            self::SD_3_5_MEDIUM,
            self::CORE,
            self::ULTRA => true,
            default     => false,
        };
    }

    public function engine(): EngineEnum
    {
        return match ($this) {
            self::IMAGE_TO_VIDEO,
            self::STABLE_DIFFUSION_XL_1024_V_1_0,
            self::STABLE_DIFFUSION_V_1_6,
            self::SD_3,
            self::SD_3_TURBO,
            self::SD_3_MEDIUM,
            self::SD_3_LARGE,
            self::SD_3_LARGE_TURBO,
            self::SD_3_5_LARGE,
            self::SD_3_5_LARGE_TURBO,
            self::SD_3_5_MEDIUM,
            self::CORE,
            self::ULTRA,
            self::AWS_BEDROCK => EngineEnum::STABLE_DIFFUSION,
            // OpenAI
            self::DAVINCI,
            self::GPT_3_5_TURBO_16K,
            self::GPT_3_5_TURBO,
            self::GPT_3_5_TURBO_0125,
            self::GPT_3_5_TURBO_1106,
            self::GPT_4_TURBO,
            self::GPT_4,
            self::GPT_4_1106_PREVIEW,
            self::GPT_4_0125_PREVIEW,
            self::GPT_4_VISION_PREVIEW,
            self::TEXT_DAVINCI_003,
            self::TEXT_EMBEDDING_ADA_002,
            self::TEXT_EMBEDDING_3_SMALL,
            self::TEXT_EMBEDDING_3_LARGE,
            self::WHISPER_1,
            self::DALL_E_2,
            self::DALL_E_3,
            self::TTS_1,
            self::TTS_1_HD,
            self::GPT_4_O,
            self::GPT_4_O_MINI,
            self::GPT_4_O1_PREVIEW,
            self::GPT_4_O1_MINI => EngineEnum::OPEN_AI,
            // Anthropic
            self::CLAUDE_3_5_SONNET,
            self::CLAUDE_3_SONNET,
            self::CLAUDE_3_OPUS,
            self::CLAUDE_3_HAIKU,
            self::CLAUDE_2_1,
            self::CLAUDE_2_0,
            self::VOYAGE_2,
            self::VOYAGE_LARGE_2,
            self::VOYAGE_CODE_2 => EngineEnum::ANTHROPIC,
            // Clipdrop
            self::CLIPDROP => EngineEnum::CLIPDROP,
            // Plagiarism Check
            self::PLAGIARISMCHECK => EngineEnum::PLAGIARISM_CHECK,
            // SYNTHESIA
            self::SYNTHESIA => EngineEnum::SYNTHESIA,
            // HEYGEN
            self::HEYGEN => EngineEnum::HEYGEN,
            // Pebblely
            self::PEBBLELY => EngineEnum::PEBBLELY,
            // Gemini
            self::GEMINI_1_5_PRO_LATEST,
            self::GEMINI_PRO,
            self::GEMINI_1_5_FLASH,
            self::GEMINI_PRO_VISION,
            self::GEMINI_TEXT_EMBEDING_004 => EngineEnum::GEMINI,
            // Unsplash
            self::UNSPLASH => EngineEnum::UNSPLASH,
            // Pexels
            self::PEXELS => EngineEnum::PEXELS,
            // Pixabay
            self::PIXABAY => EngineEnum::PIXABAY,
            // Elevenlabs
            self::ELEVENLABS,
            self::ISOLATOR => EngineEnum::ELEVENLABS,
            // Google
            self::GOOGLE => EngineEnum::GOOGLE,
            // Azure
            self::AZURE => EngineEnum::AZURE,
            // Serper
            self::SERPER => EngineEnum::SERPER,
            // FAL AI
            self::FLUX_PRO, self::FLUX_PRO_1_1, self::FLUX_REALISM, self::FLUX_SCHNELL,
            self::KLING, self::LUMA_DREAM_MACHINE, self::RUNWAY_GEN3, self::MINIMAX => EngineEnum::FAL_AI,
        };
    }

    public function driverClass(): string
    {
        return match ($this) {
            // Stable Diffusion
            self::IMAGE_TO_VIDEO                   => StableDiffusion\ImageToVideoDriver::class,
            self::STABLE_DIFFUSION_XL_1024_V_1_0   => StableDiffusion\XL1024V10Driver::class,
            self::STABLE_DIFFUSION_V_1_6           => StableDiffusion\V16Driver::class,
            self::SD_3                             => StableDiffusion\Sd3Driver::class,
            self::SD_3_TURBO                       => StableDiffusion\Sd3TurboDriver::class,
            self::SD_3_MEDIUM                      => StableDiffusion\Sd3MediumDriver::class,
            self::SD_3_LARGE                       => StableDiffusion\Sd3LargeDriver::class,
            self::SD_3_LARGE_TURBO                 => StableDiffusion\Sd3LargeTurboDriver::class,
            self::SD_3_5_LARGE                     => StableDiffusion\Sd35LargeDriver::class,
            self::SD_3_5_LARGE_TURBO               => StableDiffusion\Sd35LargeTurboDriver::class,
            self::SD_3_5_MEDIUM                    => StableDiffusion\Sd35MediumDriver::class,
            self::CORE                             => StableDiffusion\CoreDriver::class,
            self::ULTRA                            => StableDiffusion\UltraDriver::class,
            self::AWS_BEDROCK                      => StableDiffusion\AwsBedrockDriver::class,
            // OpenAI
            self::DAVINCI                => OpenAI\DavinciDriver::class,
            self::GPT_3_5_TURBO_16K      => OpenAI\GPT35Turbo16KDriver::class,
            self::GPT_3_5_TURBO          => OpenAI\GPT35TurboDriver::class,
            self::GPT_3_5_TURBO_0125     => OpenAI\GPT35Turbo0125Driver::class,
            self::GPT_3_5_TURBO_1106     => OpenAI\GPT35Turbo1106Driver::class,
            self::GPT_4_TURBO            => OpenAI\GPT4TurboDriver::class,
            self::GPT_4                  => OpenAI\GPT4Driver::class,
            self::GPT_4_1106_PREVIEW     => OpenAI\GPT41106PreviewDriver::class,
            self::GPT_4_0125_PREVIEW     => OpenAI\GPT40125PreviewDriver::class,
            self::GPT_4_VISION_PREVIEW   => OpenAI\GPT4VisionPreviewDriver::class,
            self::TEXT_DAVINCI_003       => OpenAI\TextDavinciDriver::class,
            self::TEXT_EMBEDDING_ADA_002 => OpenAI\TextEmbeddingAdaDriver::class,
            self::TEXT_EMBEDDING_3_SMALL => OpenAI\TextEmbedding3SmallDriver::class,
            self::TEXT_EMBEDDING_3_LARGE => OpenAI\TextEmbedding3LargeDriver::class,
            self::WHISPER_1              => OpenAI\Whisper1Driver::class,
            self::DALL_E_2               => OpenAI\DallE2Driver::class,
            self::DALL_E_3               => OpenAI\DallE3Driver::class,
            self::TTS_1                  => OpenAI\TTS1Driver::class,
            self::TTS_1_HD               => OpenAI\TTS1HDDriver::class,
            self::GPT_4_O                => OpenAI\GPT4ODriver::class,
            self::GPT_4_O_MINI           => OpenAI\GPT4OMiniDriver::class,
            self::GPT_4_O1_PREVIEW       => OpenAI\GPT4O1PreviewDriver::class,
            self::GPT_4_O1_MINI          => OpenAI\GPT4O1MiniDriver::class,
            // Anthropic
            self::CLAUDE_3_5_SONNET => Anthropic\Claude35SonnetDriver::class,
            self::CLAUDE_3_SONNET   => Anthropic\Claude3SonnetDriver::class,
            self::CLAUDE_3_OPUS     => Anthropic\Claude3OpusDriver::class,
            self::CLAUDE_3_HAIKU    => Anthropic\Claude3HaikuDriver::class,
            self::CLAUDE_2_1        => Anthropic\Claude21Driver::class,
            self::CLAUDE_2_0        => Anthropic\Claude20Driver::class,
            self::VOYAGE_2          => Anthropic\Voyage2Driver::class,
            self::VOYAGE_LARGE_2    => Anthropic\VoyageLarge2Driver::class,
            self::VOYAGE_CODE_2     => Anthropic\VoyageCode2Driver::class,
            // Gemini
            self::GEMINI_1_5_PRO_LATEST     => Gemini\Gemini15ProLatestDriver::class,
            self::GEMINI_PRO                => Gemini\GeminiProDriver::class,
            self::GEMINI_1_5_FLASH          => Gemini\Gemini15FlashDriver::class,
            self::GEMINI_PRO_VISION         => Gemini\GeminiProVisionDriver::class,
            self::GEMINI_TEXT_EMBEDING_004  => Gemini\GeminiTextEmbeding004Driver::class,
            // Others
            self::CLIPDROP        => ClipDropDriver::class,
            self::PLAGIARISMCHECK => PlagiarismCheckDriver::class,
            self::SYNTHESIA       => SynthesiaDriver::class,
            self::HEYGEN          => HeygenDriver::class,
            self::PEBBLELY        => PebblelyDriver::class,
            self::UNSPLASH        => UnsplashDriver::class,
            self::PEXELS          => PexelsDriver::class,
            self::PIXABAY         => PixabayDriver::class,
            self::ELEVENLABS      => ElevenLabs\ElevenlabsDriver::class,
            self::ISOLATOR        => ElevenLabs\IsolatorDriver::class,
            self::GOOGLE          => GoogleDriver::class,
            self::AZURE           => AzureDriver::class,
            self::SERPER          => SerperDriver::class,
            // FAL AI
            self::FLUX_PRO           => FalAI\FluxProDriver::class,
            self::FLUX_PRO_1_1       => FalAI\FluxPro11Driver::class,
            self::FLUX_REALISM       => FalAI\FluxRealismDriver::class,
            self::FLUX_SCHNELL       => FalAI\FluxSchnellDriver::class,
            self::KLING              => FalAI\KlingDriver::class,
            self::LUMA_DREAM_MACHINE => FalAI\LumaDreamMachineDriver::class,
            self::RUNWAY_GEN3        => FalAI\RunwayGen3Driver::class,
            self::MINIMAX            => FalAI\MinimaxDriver::class,
        };
    }

    /** @noinspection PhpDuplicateMatchArmBodyInspection */
    public function unitPrice(): float
    {
        return match ($this) {
            self::IMAGE_TO_VIDEO                 => 0.2,
            self::STABLE_DIFFUSION_XL_1024_V_1_0 => 0.006,
            self::STABLE_DIFFUSION_V_1_6         => 0.01,
            self::SD_3, self::ULTRA, self::SD_3_TURBO => 0.03,
            self::SD_3_MEDIUM        => 0.035,
            self::SD_3_LARGE         => 0.065,
            self::SD_3_LARGE_TURBO   => 0.04,
            self::SD_3_5_LARGE       => 0.065,
            self::SD_3_5_LARGE_TURBO => 0.04,
            self::SD_3_5_MEDIUM      => 0.035,
            self::CORE               => 0.02,
            self::AWS_BEDROCK        => 0.02,
            // OpenAI
            self::DAVINCI, self::GPT_3_5_TURBO_1106, self::GPT_3_5_TURBO => 0.002,
            self::GPT_3_5_TURBO_16K  => 0.004,
            self::GPT_3_5_TURBO_0125 => 0.0015,
            self::GPT_4_TURBO, self::GPT_4_1106_PREVIEW, self::GPT_4_0125_PREVIEW, self::GPT_4_VISION_PREVIEW, self::TTS_1_HD => 0.03,
            self::GPT_4                  => 0.06,
            self::TEXT_DAVINCI_003       => 0.02,
            self::TEXT_EMBEDDING_ADA_002 => 0.00005,
            self::TEXT_EMBEDDING_3_SMALL => 0.00005,
            self::TEXT_EMBEDDING_3_LARGE => 0.00005,
            self::WHISPER_1              => 0.0006,
            self::DALL_E_2               => 0.02,
            self::DALL_E_3               => 0.12,
            self::TTS_1, self::GPT_4_O => 0.015,
            self::GPT_4_O_MINI     => 0.0006,
            self::GPT_4_O1_PREVIEW => 0.06,
            self::GPT_4_O1_MINI    => 0.06,
            // Anthropic
            self::CLAUDE_3_5_SONNET, self::CLAUDE_3_SONNET => 0.015,
            self::CLAUDE_3_OPUS  => 0.075,
            self::CLAUDE_3_HAIKU => 0.00125,
            self::CLAUDE_2_1, self::CLAUDE_2_0 => 0.024,
            self::VOYAGE_2, self::VOYAGE_LARGE_2, self::VOYAGE_CODE_2 => 0.00012,
            // Others
            self::CLIPDROP        => 0.5,
            self::PLAGIARISMCHECK => 0.2,
            self::SYNTHESIA       => 0.15,
            self::HEYGEN          => 0.15,
            self::PEBBLELY        => 0.019,
            // Gemini
            self::GEMINI_1_5_PRO_LATEST, self::GEMINI_PRO_VISION => 0.021,
            self::GEMINI_PRO               => 0.0015,
            self::GEMINI_1_5_FLASH         => 0.0006,
            self::GEMINI_TEXT_EMBEDING_004 => 0.00001,
            // Unsplash
            self::UNSPLASH, self::PEXELS, self::PIXABAY => 0.0,
            // Elevenlabs
            self::ELEVENLABS, self::ISOLATOR => 0.3,
            // Google
            self::GOOGLE => 0.016,
            // Azure
            self::AZURE => 0.015,
            // Serper
            self::SERPER => 0.001,
            // FAL AI
            self::FLUX_PRO, self::FLUX_PRO_1_1, self::FLUX_REALISM, self::FLUX_SCHNELL,
            self::KLING, self::LUMA_DREAM_MACHINE, self::RUNWAY_GEN3, self::MINIMAX => 0.05,
        };
    }

    public static function getPlanLimits(EngineEnum $engine): Collection
    {
        return collect(self::listableCases())->filter(
            fn (EntityEnum $model) => $model->engine() === $engine
        )->mapWithKeys(
            fn (EntityEnum $model) => [
                $model->slug() => [
                    'credit'      => 0,
                    'isUnlimited' => false,
                ],
            ]
        );
    }

    public function subLabel(): string
    {
        $driverClass = $this->driverClass();

        return match (true) {
            class_interface_exists($driverClass, WithImagesInterface::class)        => __('Images'),
            class_interface_exists($driverClass, WithWordsInterface::class)         => __('Words'),
            class_interface_exists($driverClass, WithCharsInterface::class)         => __('Characters'),
            class_interface_exists($driverClass, WithImageToVideoInterface::class)  => __('Image to Video'),
            class_interface_exists($driverClass, WithTextToSpeechInterface::class)  => __('Text to Speech'),
            class_interface_exists($driverClass, WithSpeechToTextInterface::class)  => __('Speech to Text'),
            class_interface_exists($driverClass, WithTextToVideoInterface::class)   => __('Text to Video'),
            class_interface_exists($driverClass, WithVisionPreviewInterface::class) => __('Vision'),
            class_interface_exists($driverClass, WithPlagiarismInterface::class)    => __('Plagiarism'),
        };
    }

    public function tokenType(): AITokenType
    {
        $driverClass = $this->driverClass();

        return match (true) {
            class_interface_exists($driverClass, WithImagesInterface::class)        => AITokenType::IMAGE,
            class_interface_exists($driverClass, WithWordsInterface::class)         => AITokenType::WORD,
            class_interface_exists($driverClass, WithCharsInterface::class)         => AITokenType::CHARACTER,
            class_interface_exists($driverClass, WithImageToVideoInterface::class)  => AITokenType::IMAGE_TO_VIDEO,
            class_interface_exists($driverClass, WithTextToSpeechInterface::class)  => AITokenType::TEXT_TO_SPEECH,
            class_interface_exists($driverClass, WithSpeechToTextInterface::class)  => AITokenType::SPEECH_TO_TEXT,
            class_interface_exists($driverClass, WithTextToVideoInterface::class)   => AITokenType::TEXT_TO_VIDEO,
            class_interface_exists($driverClass, WithVisionPreviewInterface::class) => AITokenType::VISION,
            class_interface_exists($driverClass, WithPlagiarismInterface::class)    => AITokenType::PLAGIARISM
        };
    }

    public function tooltipHowToCalc(): string
    {
        $driverClass = $this->driverClass();

        return match (true) {
            class_interface_exists($driverClass, WithImagesInterface::class)        => __('1 Credit = 1 Image'),
            class_interface_exists($driverClass, WithWordsInterface::class),
            class_interface_exists($driverClass, WithSpeechToTextInterface::class),
            class_interface_exists($driverClass, WithVisionPreviewInterface::class),
            class_interface_exists($driverClass, WithPlagiarismInterface::class)    => __('1 Credit = 1 Word'),
            class_interface_exists($driverClass, WithCharsInterface::class)         => __('1 Credit = 1 Character'),
            class_interface_exists($driverClass, WithImageToVideoInterface::class),
            class_interface_exists($driverClass, WithTextToVideoInterface::class)   => __('1 Credit = 1 Video'),
            class_interface_exists($driverClass, WithTextToSpeechInterface::class)  => __('1 Credit = 1 Voice'),
        };
    }

    public static function entityDrivers(): array
    {
        return [
            WithImagesInterface::class,
            WithWordsInterface::class,
            WithCharsInterface::class,
            WithImageToVideoInterface::class,
            WithTextToSpeechInterface::class,
            WithSpeechToTextInterface::class,
            WithTextToVideoInterface::class,
            WithVisionPreviewInterface::class,
            WithPlagiarismInterface::class,
        ];
    }

    public function defaultCreditForDemo(): float
    {
        $driverClass = $this->driverClass();

        return match (true) {
            class_interface_exists($driverClass, WithImagesInterface::class)     => 200,
            class_interface_exists($driverClass, WithWordsInterface::class),
            class_interface_exists($driverClass, WithCharsInterface::class)      => 5000,
            class_interface_exists($driverClass, WithImageToVideoInterface::class),
            class_interface_exists($driverClass, WithTextToSpeechInterface::class),
            class_interface_exists($driverClass, WithSpeechToTextInterface::class),
            class_interface_exists($driverClass, WithTextToVideoInterface::class),
            class_interface_exists($driverClass, WithVisionPreviewInterface::class),
            class_interface_exists($driverClass, WithPlagiarismInterface::class) => 100,
        };
    }

    public function isBetaEntity(): bool
    {
        return match ($this) {
            self::GPT_4_O1_PREVIEW,
            self::GPT_4_O1_MINI => true,
            default             => false,
        };
    }

    public static function embedingModels(EngineEnum $engineEnum): array
    {
        return match ($engineEnum) {
            EngineEnum::ANTHROPIC => [
                self::VOYAGE_2,
                self::VOYAGE_CODE_2,
                self::VOYAGE_LARGE_2,
            ],
            EngineEnum::GEMINI => [
                self::GEMINI_TEXT_EMBEDING_004,
            ],
            default => [
                self::TEXT_EMBEDDING_ADA_002,
                self::TEXT_EMBEDDING_3_SMALL,
                self::TEXT_EMBEDDING_3_LARGE,
            ]
        };
    }

    public static function reWriterModels(EngineEnum $engineEnum): array
    {
        return match ($engineEnum) {
            default => [
                self::DAVINCI,
                self::GPT_3_5_TURBO_16K,
                self::GPT_3_5_TURBO,
                self::GPT_3_5_TURBO_0125,
                self::GPT_4,
                self::GPT_4_1106_PREVIEW,
                self::GPT_4_0125_PREVIEW,
                self::GPT_4_TURBO,
                self::GPT_4_O,
                self::GPT_4_O_MINI,
                self::GPT_4_O1_PREVIEW,
                self::GPT_4_O1_MINI,
            ]
        };
    }
}
