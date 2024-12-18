<?php

namespace MagicAI\Updater\Traits;

use App\Domains\Marketplace\Repositories\Contracts\ExtensionRepositoryInterface;
use App\Helpers\Classes\InstallationHelper;
use App\Models\Setting;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\ValidationException;
use MagicAI\Updater\Exceptions\InvalidURLException;
use MagicAI\Updater\Exceptions\ZipException;
use RuntimeException;

trait HasVersionUpdate
{
    public function updateNewVersion(string $backupFileName): bool
    {
        $blackList = app(ExtensionRepositoryInterface::class)->blacklist();

        if ($blackList) {
            throw ValidationException::withMessages([
                'message' => 'Please try again later!',
            ]);
        }

        $versionRequest = $this->versionRequest();

        $version = $versionRequest->json('version');

        $downloadUrl = config('magicai-updater.base_url') . $versionRequest->json('archive');

        try {
            if (File::exists(base_path('bootstrap/cache/packages.php'))) {
                File::delete(base_path('bootstrap/cache/packages.php'));
            }

            if (File::exists(base_path('bootstrap/cache/services.php'))) {
                File::delete(base_path('bootstrap/cache/services.php'));
            }

            DB::beginTransaction();

            Artisan::call('config:clear');
            Artisan::call('cache:clear');
            Artisan::call('route:clear');
            Artisan::call('view:clear');
            Artisan::call('optimize:clear');

            $downloadFile = $this->download($downloadUrl, 'new-version' . $version . '.zip');

            Artisan::call('down');

            $this->unzip($downloadFile);

            $this->migrate();

            $this->updateVersion($version);

            InstallationHelper::runInstallation();

            Artisan::call('up');

        } catch (InvalidURLException|ZipException|RuntimeException $e) {
            DB::rollBack();

            $this->rollbackBackup($backupFileName);

            Artisan::call('up');

            throw ValidationException::withMessages([
                'message' => $e->getMessage(),
            ]);
        }

        return true;
    }

    private function rollbackBackup(string $backupFileName): void
    {
        $this->unzip(base_path($backupFileName));
    }

    private function updateVersion(string $version): void
    {
        $setting = Setting::getCache();
        $setting->script_version = $version;
        $setting->save();

        File::put(base_path('version.txt'), $version);
    }

    private function migrate(): void
    {
        Artisan::call('migrate', ['--force' => true]);
    }
}
