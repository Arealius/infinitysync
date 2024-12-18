<?php

declare(strict_types=1);

namespace App\Domains\Marketplace;

use App\Domains\Marketplace\Repositories\Contracts\ExtensionRepositoryInterface;
use App\Domains\Marketplace\Repositories\ExtensionRepository;
use App\Domains\Marketplace\Services\ExtensionInstallService;
use App\Domains\Marketplace\Services\ExtensionUninstallService;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class MarketplaceServiceProvider extends ServiceProvider
{
    /**
     * The service provider bindings.
     */
    public array $bindings = [
        ExtensionRepositoryInterface::class => ExtensionRepository::class,
    ];

    /**
     * The service provider bindings.
     *
     * @note Do not remove namespaces from the beginning of the class.
     */
    public static array $extensionProviders = [
        'chatbot'              => \App\Extensions\Chatbot\System\ChatbotServiceProvider::class,
        'focus-mode'           => \App\Extensions\FocusMode\System\FocusModeServiceProvider::class,
        'newsletter'           => \App\Extensions\Newsletter\System\NewsletterServiceProvider::class,
        'photo-studio'         => \App\Extensions\PhotoStudio\System\PhotoStudioServiceProvider::class,
        'ai-product-shot'      => \App\Extensions\ProductPhotography\System\ProductPhotographyServiceProvider::class,
        'ai-avatar'            => \App\Extensions\AiAvatar\System\AiAvatarServiceProvider::class,
        'ai-avatar-pro'        => \App\Extensions\AiAvatarPro\System\AiAvatarProServiceProvider::class,
        'ai-music'             => \App\Extensions\AiMusic\System\AiMusicServiceProvider::class,
        'ai-replica'           => \App\Extensions\AiReplica\System\AiReplicaServiceProvider::class,
        'ai-fall-video'        => \App\Extensions\AiFall\System\AiFallVideoServiceProvider::class,
        'seo-tool'             => \App\Extensions\SEOTool\System\SEOToolServiceProvider::class,
        'ai-social-media'      => \App\Extensions\AISocialMedia\System\AISocialMediaServiceProvider::class,
        'webchat'              => \App\Extensions\AIWebChat\System\AIWebChatServiceProvider::class,
        'introductions'        => \App\Extensions\Introduction\System\IntroductionServiceProvider::class,
        'flux-pro'             => \App\Extensions\FluxPro\System\FluxProServiceProvider::class,
        'chat-share'           => \App\Extensions\ChatShare\System\ChatShareServiceProvider::class,
        'voice-isolator'       => \App\Extensions\AIVoiceIsolator\System\AIVoiceIsolatorServiceProvider::class,
        'chat-setting'         => \App\Extensions\ChatSetting\System\ChatSettingServiceProvider::class,
        'hubspot'              => \App\Extensions\Hubspot\System\HubspotServiceProvider::class,
        'menu'                 => \App\Extensions\Menu\System\MenuServiceProvider::class,
        'azure-tts'            => \App\Extensions\AzureTTS\System\AzureTTSServiceProvider::class,
        'plagiarism'           => \App\Extensions\AIPlagiarism\System\AIPlagiarismServiceProvider::class,
        'cloudflare-r2'        => \App\Extensions\Cloudflare\System\CloudflareServiceProvider::class,
        'wordpress'            => \App\Extensions\Wordpress\System\WordpressServiceProvider::class,
        'cryptomus'            => \App\Extensions\Cryptomus\System\CryptomusServiceProvider::class,
        'affilate'             => \App\Extensions\Affilate\System\AffilateServiceProvider::class,
        'mailchimp-newsletter' => \App\Extensions\Mailchimp\System\MailchimpServiceProvider::class,
        'ai-writer-templates'  => \App\Extensions\AIWriterTemplates\System\AIWriterTemplateServiceProvider::class,
        'maintenance'          => \App\Extensions\Maintenance\System\MaintenanceServiceProvider::class,
    ];

    public function register(): void
    {
        $this->extensionProviderRegister();
    }

    public function boot(): void
    {
        $this->registerRoutes();
    }

    private function registerRoutes(): void
    {
        $this->router()
            ->group([
                'prefix'     => LaravelLocalization::setLocale(),
                'middleware' => ['web', 'auth', 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath'],
            ], function (Router $route) {
                $route->get('dashboard/marketplace/extension/{slug}/install', function (string $slug) {
                    return $this
                        ->app
                        ->make(ExtensionInstallService::class)
                        ->install($slug);
                })->name('marketplace.extension.install');

                $route->get('dashboard/marketplace/extension/{slug}/uninstall', function (string $slug) {
                    return $this
                        ->app
                        ->make(ExtensionUninstallService::class)
                        ->uninstall($slug);
                })->name('marketplace.extension.uninstall');
            });
    }

    private function router(): Router|Route
    {
        return $this->app['router'];
    }

    public function extensionProviderRegister(): void
    {
        foreach (static::$extensionProviders as $provider) {
            if (class_exists($provider)) {
                $this->app->register($provider);
            }
        }
    }

    public static function uninstallExtension(string $slug): void
    {
        if (isset(self::$extensionProviders[$slug])) {

            $provider = self::$extensionProviders[$slug];

            if (method_exists($provider, 'uninstall')) {
                $provider::uninstall();
            }
        }
    }

    public static function getExtensionProviders(): array
    {
        return static::$extensionProviders;
    }
}
