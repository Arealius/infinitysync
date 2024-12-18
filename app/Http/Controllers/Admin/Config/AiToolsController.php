<?php

namespace App\Http\Controllers\Admin\Config;

use App\Http\Controllers\Controller;
use App\Models\Extension;
use App\Models\Setting;
use App\Models\SettingTwo;
use App\Services\Common\MenuService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AiToolsController extends Controller
{
    protected $settings;

    protected $settingTwo;

    public function __construct()
    {
        $this->settings = Setting::getCache();
        $this->settingTwo = SettingTwo::getCache();
    }

    public function index(): View
    {
        $chatSetting = Extension::query()
            ->where('slug', 'chat-setting')
            ->where('installed', true)
            ->exists();

        return view('panel.admin.config.tools', compact(['chatSetting']));
    }

    public function store(Request $request): RedirectResponse
    {
        $this->settings->update([
            'feature_ai_writer'          => $request->has('feature_ai_writer'),
            'feature_ai_advanced_editor' => $request->has('feature_ai_advanced_editor'),
            'feature_ai_image'           => $request->has('feature_ai_image'),
            'feature_ai_chat'            => $request->has('feature_ai_chat'),
            'feature_ai_code'            => $request->has('feature_ai_code'),
            'feature_ai_speech_to_text'  => $request->has('feature_ai_speech_to_text'),
            'feature_ai_voiceover'       => $request->has('feature_ai_voiceover'),
            'feature_affilates'          => $request->has('feature_affilates'),
            'feature_ai_article_wizard'  => $request->has('feature_ai_article_wizard'),
            'feature_ai_vision'          => $request->has('feature_ai_vision'),
            'feature_ai_chat_image'      => $request->has('feature_ai_chat_image'),
            'feature_ai_pdf'             => $request->has('feature_ai_pdf'),
            'feature_ai_rewriter'        => $request->has('feature_ai_rewriter'),
            'feature_ai_youtube'         => $request->has('feature_ai_youtube'),
            'feature_ai_rss'             => $request->has('feature_ai_rss'),
            'feature_ai_voice_clone'     => $request->has('feature_ai_voice_clone'),
            'team_functionality'         => $request->has('team_functionality'),
            'user_api_option'            => $request->has('user_api_option'),
        ]);

        $this->settingTwo->update([
            'feature_ai_video'          => $request->has('feature_ai_video'),
            'daily_voice_limit_enabled' => $request->has('daily_voice_limit_enabled'),
            'daily_limit_enabled'       => $request->has('daily_limit_enabled'),
        ]);

        setting(
            [
                'default_ai_engine'               => $request->get('default_ai_engine'),
                'default_aw_image_engine'         => $request->get('default_aw_image_engine'),
                'chat_setting_for_customer'       => $request->has('chat_setting_for_customer') ? 1 : 0,
                'user_prompt_library'             => $request->has('user_prompt_library') ? 1 : 0,
                'user_ai_image_prompt_library'    => $request->has('user_ai_image_prompt_library') ? 1 : 0,
                'ai_voice_isolator'               => $request->has('ai_voice_isolator') ? 1 : 0,
                'select_model_option'             => $request->has('select_model_option') ? 1 : 0,
                'user_ai_writer_custom_templates' => $request->has('user_ai_writer_custom_templates') ? 1 : 0,
            ]
        )->save();

        app(MenuService::class)->regenerate();

        return back()->with(['message' => 'Updated Successfully.', 'type' => 'success']);
    }
}
