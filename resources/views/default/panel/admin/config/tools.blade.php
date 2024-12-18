@extends('panel.layout.settings')
@section('title', __('AI Tools Settings'))
@section('titlebar_actions', '')
@section('additional_css')

@endsection

@section('settings')
    <form
        action="{{ route('dashboard.admin.config.ai-tools.store') }}"
        method="POST"
    >
        @csrf
        <x-form-step
            class="mb-3"
            step="1"
        >
            {{ __('AI Tools Settings') }}
        </x-form-step>
        <div class="col-md-12 mb-4">
            <div class="mb-3">
                <label class="form-label">@lang('Default AI engine')</label>
                <select
                    class="form-select"
                    id="default_ai_engine"
                    name="default_ai_engine"
                >
                    <option
                        value="openai"
                        {{ setting('default_ai_engine') == 'openai' ? 'selected' : '' }}
                    >
                        {{ __('OpenAI') }}</option>
                    <option
                        value="anthropic"
                        {{ setting('default_ai_engine') == 'anthropic' ? 'selected' : '' }}
                    >
                        {{ __('Anthropic') }}</option>
                    <option
                        value="gemini"
                        {{ setting('default_ai_engine') == 'gemini' ? 'selected' : '' }}
                    >
                        {{ __('Gemini') }}</option>
                </select>
            </div>
        </div>

        <div class="col-md-12 mb-4">
            <div class="mb-3">
                <label class="form-label">{{ __('Article Wizard default image engine') }}

                </label>
                <select
                    class="form-select"
                    id="default_aw_image_engine"
                    name="default_aw_image_engine"
                >
                    <option
                        value="unsplash"
                        {{ setting('default_aw_image_engine', 'unsplash') == 'unsplash' ? 'selected' : '' }}
                    >
                        {{ __('Unsplash') }}</option>
                    <option
                        value="pexels"
                        {{ setting('default_aw_image_engine', 'unsplash') == 'pexels' ? 'selected' : '' }}
                    >
                        {{ __('Pexels') }}</option>
                    <option
                        value="pixabay"
                        {{ setting('default_aw_image_engine', 'unsplash') == 'pixabay' ? 'selected' : '' }}
                    >
                        {{ __('Pixabay') }}</option>
                    <option
                        value="openai"
                        {{ setting('default_aw_image_engine', 'unsplash') == 'openai' ? 'selected' : '' }}
                    >
                        {{ __('Openai Dall-E') }}</option>
                    <option
                        value="sd"
                        {{ setting('default_aw_image_engine', 'unsplash') == 'sd' ? 'selected' : '' }}
                    >
                        {{ __('Stable Diffusion') }}</option>
                </select>
            </div>
        </div>

        <div class="row mb-4 mt-4">
            <div class="mb-3">
                <div class="form-label">{{ __('Manage the features you want to activate for users.') }}</div>
                <x-forms.input
                    class:container="mb-2"
                    id="feature_ai_writer"
                    name="feature_ai_writer"
                    type="checkbox"
                    :checked="$setting->feature_ai_writer == 1"
                    label="{{ __('AI Writer') }}"
                    switcher
                />
                <x-forms.input
                    class:container="mb-2"
                    id="feature_ai_advanced_editor"
                    name="feature_ai_advanced_editor"
                    type="checkbox"
                    :checked="$setting->feature_ai_advanced_editor == 1"
                    label="{{ __('AI advanced editor') }}"
                    switcher
                />
                <x-forms.input
                    class:container="mb-2"
                    id="feature_ai_image"
                    name="feature_ai_image"
                    type="checkbox"
                    :checked="$setting->feature_ai_image == 1"
                    label="{{ __('AI Image') }}"
                    switcher
                />
                <x-forms.input
                    class:container="mb-2"
                    id="feature_ai_video"
                    name="feature_ai_video"
                    type="checkbox"
                    :checked="$settings_two->feature_ai_video == 1"
                    label="{{ __('AI Video') }}"
                    switcher
                />
                <x-forms.input
                    class:container="mb-2"
                    id="feature_ai_chat"
                    name="feature_ai_chat"
                    type="checkbox"
                    :checked="$setting->feature_ai_chat == 1"
                    label="{{ __('AI Chat') }}"
                    switcher
                />
                <x-forms.input
                    class:container="mb-2"
                    id="feature_ai_code"
                    name="feature_ai_code"
                    type="checkbox"
                    :checked="$setting->feature_ai_code == 1"
                    label="{{ __('AI Code') }}"
                    switcher
                />
                <x-forms.input
                    class:container="mb-2"
                    id="feature_ai_speech_to_text"
                    name="feature_ai_speech_to_text"
                    type="checkbox"
                    :checked="$setting->feature_ai_speech_to_text == 1"
                    label="{{ __('AI Speech to Text') }}"
                    switcher
                />
                <x-forms.input
                    class:container="mb-2"
                    id="feature_ai_voiceover"
                    name="feature_ai_voiceover"
                    type="checkbox"
                    :checked="$setting->feature_ai_voiceover == 1"
                    label="{{ __('AI Voiceover') }}"
                    switcher
                />
                <x-forms.input
                    class:container="mb-2"
                    id="feature_affilates"
                    name="feature_affilates"
                    type="checkbox"
                    :checked="$setting->feature_affilates == 1"
                    label="{{ __('Affilates') }}"
                    switcher
                />
                <x-forms.input
                    class:container="mb-2"
                    id="feature_ai_article_wizard"
                    name="feature_ai_article_wizard"
                    type="checkbox"
                    :checked="$setting->feature_ai_article_wizard == 1"
                    label="{{ __('Article Wizard') }}"
                    switcher
                />
                <x-forms.input
                    class:container="mb-2"
                    id="feature_ai_vision"
                    name="feature_ai_vision"
                    type="checkbox"
                    :checked="$setting->feature_ai_vision == 1"
                    label="{{ __('AI Vision') }}"
                    switcher
                />
                <x-forms.input
                    class:container="mb-2"
                    id="feature_ai_chat_image"
                    name="feature_ai_chat_image"
                    type="checkbox"
                    :checked="$setting->feature_ai_chat_image == 1"
                    label="{{ __('Chat Image') }}"
                    switcher
                />
                <x-forms.input
                    class:container="mb-2"
                    id="feature_ai_pdf"
                    name="feature_ai_pdf"
                    type="checkbox"
                    :checked="$setting->feature_ai_pdf == 1"
                    label="{{ __('AI File Chat') }}"
                    switcher
                />
                <x-forms.input
                    class:container="mb-2"
                    id="feature_ai_rewriter"
                    name="feature_ai_rewriter"
                    type="checkbox"
                    :checked="$setting->feature_ai_rewriter == 1"
                    label="{{ __('AI Rewriter') }}"
                    switcher
                />
                <x-forms.input
                    class:container="mb-2"
                    id="feature_ai_youtube"
                    name="feature_ai_youtube"
                    type="checkbox"
                    :checked="$setting->feature_ai_youtube == 1"
                    label="{{ __('AI YouTube') }}"
                    switcher
                />
                <x-forms.input
                    class:container="mb-2"
                    id="feature_ai_rss"
                    name="feature_ai_rss"
                    type="checkbox"
                    :checked="$setting->feature_ai_rss == 1"
                    label="{{ __('AI RSS') }}"
                    switcher
                />
                <x-forms.input
                    class:container="mb-2"
                    id="feature_ai_voice_clone"
                    name="feature_ai_voice_clone"
                    type="checkbox"
                    :checked="$setting->feature_ai_voice_clone == 1"
                    label="{{ __('AI VoiceClone') }}"
                    switcher
                />
                <x-forms.input
                    class:container="mb-2"
                    id="team_functionality"
                    name="team_functionality"
                    type="checkbox"
                    :checked="$setting->team_functionality == 1"
                    label="{{ __('Team Functionality') }}"
                    switcher
                />
                @if ($chatSetting)
                    <x-forms.input
                        class:container="mb-2"
                        id="chat_setting_for_customer"
                        name="chat_setting_for_customer"
                        type="checkbox"
                        :checked="setting('chat_setting_for_customer', '1') == '1'"
                        label="{{ __('Chat Setting (Extension)') }}"
                        switcher
                    />
                @endif
                <x-forms.input
                    class:container="mb-2"
                    id="user_prompt_library"
                    name="user_prompt_library"
                    type="checkbox"
                    :checked="setting('user_prompt_library') == 1 || setting('user_prompt_library') == null"
                    label="{{ __('AI Chat Prompt Library') }}"
                    switcher
                />
                <x-forms.input
                    class:container="mb-2"
                    id="user_ai_image_prompt_library"
                    name="user_ai_image_prompt_library"
                    type="checkbox"
                    :checked="setting('user_ai_image_prompt_library') == 1 || setting('user_ai_image_prompt_library') == null"
                    label="{{ __('AI Image Prompt Library') }}"
                    switcher
                />
                <x-forms.input
                    class:container="mb-2"
                    id="ai_voice_isolator"
                    name="ai_voice_isolator"
                    type="checkbox"
                    :checked="setting('ai_voice_isolator', '1') == '1'"
                    label="{{ __('AI Voice Isolator') }}"
                    switcher
                />
                <x-forms.input
                    class:container="mb-2"
                    id="select_model_option"
                    name="select_model_option"
                    type="checkbox"
                    :checked="setting('select_model_option', '0') == '1'"
                    label="{{ __('Select Model Option') }}"
                    switcher
                />
                @includeFirst([
                    'photo-studio::particles.photo-studio-general-setting',
                    'default.panel.admin.settings.particles.photo-studio-general-setting',
                    'vendor.empty',
                ])
            </div>
            <x-form-step
                class="mb-3 mt-7"
                step="2"
            >
                {{ __('AI Writer Users Custom Templates') }}
                <x-badge
                    class="ms-2 text-2xs"
                    variant="primary"
                >
                    @lang('New')
                </x-badge>
            </x-form-step>
            <div class="row mb-4">
                <div class="mb-3">
                    <div class="mb-4">
                        {{ __('Upon activating this feature, the users will be able to create there own custom templates.') }}
                    </div>
                    <x-forms.input
                        id="user_ai_writer_custom_templates"
                        name="user_ai_writer_custom_templates"
                        type="checkbox"
                        :checked="setting('user_ai_writer_custom_templates', 1) == 1"
                        switcher
                        label="{{ __('Users Custom AI Writer Templates') }}"
                    />
                </div>
            </div>

            <x-form-step
                class="mb-3 mt-7"
                step="3"
            >
                {{ __('Users API Key Option') }}
            </x-form-step>
            <div class="row mb-4">
                <div class="mb-3">
                    <div class="mb-4">
                        {{ __('Upon activating this feature, the admin API key will be deactivated, and users will need to input their own API keys for continued functionality.') }}
                    </div>
                    <x-forms.input
                        id="user_api_option"
                        name="user_api_option"
                        type="checkbox"
                        :checked="$setting?->user_api_option == 1"
                        switcher
                        label="{{ __('Convert To Users API') }}"
                    />
                </div>
            </div>

            <div class="col-12">
                <button
                    class="btn btn-primary w-full"
                    type="submit"
                >
                    {{ __('Save') }}
                </button>
            </div>
        </div>
    </form>
@endsection

@push('script')
@endpush
