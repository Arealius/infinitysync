<?php

namespace MagicAI\Updater\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use MagicAI\Updater\Facades\Updater;

class UpdaterController
{
    public function index(Request $request): View
    {
        return view('magicai-updater::index', [
            'permission' => true,
            'data'       => Updater::checker(),
            'user'       => $request->user(),
        ]);
    }

    public function check(): array
    {
        return Updater::checker();
    }

    public function update(Request $request): RedirectResponse
    {
        Updater::downloadNewUpdater();

        return back()->with([
            'message' => trans('The updater has been successfully downloaded.'),
            'type'    => 'success',
        ]);
    }

    public function upgrade(Request $request): RedirectResponse
    {
        $backupFileName = Updater::backup();

        Updater::updateNewVersion($backupFileName);

        return back()->with([
            'message' => trans('The updater has been successfully downloaded.'),
            'type'    => 'success',
        ]);
    }

    public function forPanel(): JsonResponse
    {
        return response()->json(Updater::forPanel());
    }
}
