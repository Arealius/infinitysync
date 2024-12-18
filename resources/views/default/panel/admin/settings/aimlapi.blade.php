@extends('panel.layout.settings')
@section('title', __('Aimlapi Settings'))
@section('titlebar_actions', '')

@section('additional_css')
    <link
            href="{{ custom_theme_url('/assets/libs/select2/select2.min.css') }}"
            rel="stylesheet"
    />
@endsection

@section('settings')
    <form
            id="settings_form"
            onsubmit="return aimlapiSettingsSave();"
            enctype="multipart/form-data"
    >
        <x-card
                class="mb-2 max-md:text-center"
                szie="lg"
        >

            @if ($app_is_demo)
                <div class="mb-3">
                    <label class="form-label">{{ __('Aimlapi API Key') }}</label>
                    <input
                            class="form-control"
                            id=""
                            type="text"
                            name="aimlapi_key"
                            value="*********************"
                    >
                </div>
            @else
                <div
                        class="form-control mb-3 border-none p-0 [&_.select2-selection--multiple]:!rounded-[--tblr-border-radius] [&_.select2-selection--multiple]:!border-[--tblr-border-color] [&_.select2-selection--multiple]:!p-[1em_1.23em]">
                    <label class="form-label">{{ __('Aimlapi API Key') }}
                        <x-alert class="mt-2">
                            <x-button
                                    variant="link"
                                    href="https://aimlapi.com/"
                                    target="_blank"
                            >
                                {{ __('Get an API key') }}
                            </x-button>
                        </x-alert>
                    </label>
                    <input
                            class="form-control"
                            id="aimlapi_key"
                            type="text"
                            name="aimlapi_key"
                            value="{{ $setting->aimlapi_key }}"
                    >
                    <x-alert
                            class="mt-2"
                            variant="lg"
                    >
                        <p>
                            {{ __('Please ensure that your Aimlapi api key is fully functional and billing defined on your Aimlapi account.') }}
                        </p>
                    </x-alert>
                </div>

                <div class="col-md-12">
                    <div class="mb-3">
                        <x-card
                                class="w-full"
                                size="sm"
                        >
                            <label class="form-label">{{ __('Default AI Music Model') }}</label>
                            <select
                                    class="form-select"
                                    id="ai_music_model"
                                    name="ai_music_model"
                            >
                                <option
                                        value="chirp-v3.5"
                                        {{ $setting->ai_music_model == 'chirp-v3.5' ? 'selected' : null }}
                                >
                                    {{ __('Chirp 3.5') }}</option>
                                <option
                                        value="chirp-v3"
                                        {{ $setting->ai_music_model == 'chirp-v3' ? 'selected' : null }}
                                >
                                    {{ __('Chirp 3') }}</option>
                                <option
                                        value="chirp-v2"
                                        {{ $setting->ai_music_model == 'chirp-v2' ? 'selected' : null }}
                                >
                                    {{ __('Chirp 2') }}</option>
                            </select>
                        </x-card>
                    </div>
                </div>
            @endif

        </x-card>
        <button
                class="btn btn-primary w-full"
                id="settings_button"
                form="settings_form"
        >
            {{ __('Save') }}
        </button>
    </form>
@endsection

@push('script')
    <script src="{{ custom_theme_url('/assets/js/panel/settings.js') }}"></script>
    <script src="{{ custom_theme_url('/assets/libs/select2/select2.min.js') }}"></script>
@endpush
