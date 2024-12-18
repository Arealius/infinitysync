<?php

namespace App\Http\Controllers\Admin\Config;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GdprController extends Controller
{
    protected $settings;

    public function __construct()
    {
        $this->settings = Setting::query()->first();
    }

    public function index(): View
    {
        return view('panel.admin.config.gdpr');
    }

    public function store(Request $request): RedirectResponse
    {
        $this->settings->update([
            'gdpr_status'  => $request->has('gdpr_status'),
            'gdpr_button'  => $request->get('gdpr_button'),
            'gdpr_content' => $request->get('gdpr_content'),
        ]);

        return back()->with(['message' => 'Updated Successfully.', 'type' => 'success']);
    }
}
