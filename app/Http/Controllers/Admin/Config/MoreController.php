<?php

namespace App\Http\Controllers\Admin\Config;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MoreController extends Controller
{
    protected $settings;

    public function __construct()
    {
        $this->settings = Setting::query()->first();
    }

    public function index(): View
    {
        return view('panel.admin.config.more');
    }

    public function store(Request $request): RedirectResponse
    {
        $this->settings->update([
            'tour_seen'                  => $request->get('tour_seen'),
            'dashboard_code_before_head' => $request->get('dashboard_code_before_head'),
            'dashboard_code_before_body' => $request->get('dashboard_code_before_body'),
            'mrrobot_name'               => $request->get('mrrobot_name'),
            'mrrobot_search_words'       => $request->get('mrrobot_search_words'),
            'mobile_payment_active'      => $request->has('mobile_payment_active'),
        ]);

        setting(
            [
                'notification_active' => $request->has('notification_active') ? 1 : 0,
                'pusher_app_id'       => $request->get('pusher_app_id'),
                'pusher_app_key'      => $request->get('pusher_app_key'),
                'pusher_app_secret'   => $request->get('pusher_app_secret'),
                'pusher_app_cluster'  => $request->get('pusher_app_cluster'),
                'default_realtime'    => $request->get('default_realtime'),
            ]
        )->save();

        return back()->with(['message' => 'Updated Successfully.', 'type' => 'success']);
    }
}
