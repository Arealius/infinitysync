@php
    $theme = get_theme();
    $disable_floating_menu = true;
    $wide_layout_px_class = Theme::getSetting('wideLayoutPaddingX', '');
    $theme_google_fonts = Theme::getSetting('dashboard.googleFonts');
    $sidebarEnabledPages = Theme::getSetting('dashboard.sidebarEnabledPages') ?? [];
    $has_sidebar = in_array(Route::currentRouteName(), $sidebarEnabledPages, true) || (isset($has_sidebar) && $has_sidebar);

    if (!empty($wide_layout_px)) {
        $wide_layout_px_class = $wide_layout_px;
    }
@endphp
<!doctype html>
<html class="scroll-smooth" lang="{{ LaravelLocalization::getCurrentLocale() }}" dir="{{ LaravelLocalization::getCurrentLocaleDirection() }}">
@include('panel.layout.partials.head')
<body data-theme="{{ setting('dash_theme') }}" @class([
    'group/body bg-background font-body text-xs text-foreground antialiased transition-bg',
    'has-sidebar' => $has_sidebar,
    'is-admin-page' =>
        Auth::check() &&
        (Route::is('dashboard.admin*') ||
            Route::is('dashboard.blog*') ||
            Route::is('dashboard.page*')),
    'is-auth-page' => Route::is('login', 'register', 'forgot_password'),
])>

@includeIf('panel.layout.after-body-open')

@include('panel.layout.partials.mode-script')

@include('panel.layout.partials.loading')

@include('default.panel.layout.partials.top-notice-bar')

    <div class="lqd-page relative flex min-h-full flex-col">

        <div class="lqd-page-wrapper grow-1 flex">
            @auth
                @if (!isset($disable_navbar))
                    @include('panel.layout.navbar')
                @endif
            @endauth

            <div class="lqd-page-content-wrap flex grow flex-col overflow-hidden">
                @if ($good_for_now)
                    @auth
                        @if (!isset($disable_header))
                            @include('panel.layout.header', ['layout_wide', isset($layout_wide) ? $layout_wide : ''])
                        @endif
                        @if (!isset($disable_titlebar))
                            @include('panel.layout.titlebar', ['layout_wide', isset($layout_wide) ? $layout_wide : ''])
                        @endif
                    @endauth
                    @yield('before_content_container')
                    <div @class([
                            'lqd-page-content-container',
                            'h-full',
                            'container' => !isset($layout_wide) || empty($layout_wide),
                            'container-fluid' => isset($layout_wide) && !empty($layout_wide),
                            $wide_layout_px_class =>
                                filled($wide_layout_px_class) &&
                                (isset($layout_wide) && !empty($layout_wide)),
                        ])>
                        @yield('content')
                    </div>
                @elseif(Auth::check() && !$good_for_now && Route::currentRouteName() != 'dashboard.admin.settings.general')
                    <div @class([
                            'lqd-page-content-container',
                            'container' => !isset($layout_wide) || empty($layout_wide),
                            'container-fluid' => isset($layout_wide) && !empty($layout_wide),
                            $wide_layout_px_class =>
                                filled($wide_layout_px_class) &&
                                (isset($layout_wide) && !empty($layout_wide)),
                        ])>
                        @include('vendor.installer.magicai_c4st_Act')
                    </div>
                @else
                    @auth
                        @if (!isset($disable_header))
                            @include('panel.layout.header', ['layout_wide', isset($layout_wide) ? $layout_wide : ''])
                        @endif
                        @if (!isset($disable_titlebar))
                            @include('panel.layout.titlebar', ['layout_wide', isset($layout_wide) ? $layout_wide : ''])
                        @endif
                    @endauth
                    @yield('before_content_container')
                    <div @class([
                            'lqd-page-content-container',
                            'container' => !isset($layout_wide) || empty($layout_wide),
                            'container-fluid' => isset($layout_wide) && !empty($layout_wide),
                            $wide_layout_px_class =>
                                filled($wide_layout_px_class) &&
                                (isset($layout_wide) && !empty($layout_wide)),
                        ])>
                        @yield('content')
                    </div>
                @endif
                @auth
                    @if (!isset($disable_footer))
                        @include('panel.layout.footer')
                    @endif

                    @if ($has_sidebar && (!isset($disable_default_sidebar) || empty($disable_default_sidebar)))
                        @includeIf('panel.layout.sidebar')
                    @endif
                @endauth
            </div>
        </div>
    </div>

    @auth
        @if (!isset($disable_floating_menu))
            <x-floating-menu/>
        @endif
        @if (!isset($disable_mobile_bottom_menu))
            <x-bottom-menu/>
        @endif
    @endauth

    @if (!isset($disableChatbot))
        @includeWhen(in_array($settings_two->chatbot_status, ['dashboard', 'both']) &&
                !activeRoute('dashboard.user.openai.chat.list', 'dashboard.user.openai.chat.chat', 'dashboard.user.openai.webchat.workbook') &&
                !(route('dashboard.user.openai.generator.workbook', 'ai_vision') == url()->current()) &&
                !(route('dashboard.user.openai.generator.workbook', 'ai_chat_image') == url()->current()) &&
                !(route('dashboard.user.openai.generator.workbook', 'ai_pdf') == url()->current()),
            'panel.chatbot.widget')
    @endif
    @include('panel.layout.scripts')

    @if (session()->has('message'))
        <script>
            toastr.{{ session('type') }}('{{ session('message') }}');
        </script>
    @endif

    @if ($errors->any())
        <script>
            @foreach ($errors->all() as $error)
            toastr.error('{{ $error }}');
            @endforeach
        </script>
    @endif

    @auth
        {{--        <script type="module"> --}}
        {{--            Echo.private(`App.Models.User.{{ auth()->user()?->id }}`) --}}
        {{--                .listen(".Illuminate\\Notifications\\Events\\BroadcastNotificationCreated", (notification) => { --}}
        {{--                    if (Alpine) { --}}
        {{--                        Alpine.store('notifications').add({ --}}
        {{--                            id: notification.id, --}}
        {{--                            title: notification.data.title, --}}
        {{--                            message: notification.data.message, --}}
        {{--                            link: notification.data.link, --}}
        {{--                            unread: true --}}
        {{--                        }) --}}
        {{--                    } --}}
        {{--                }); --}}
        {{--        </script> --}}
    @endauth
    @stack('script')

    <script src="{{ custom_theme_url('/assets/js/frontend.js') }}"></script>

    @if ($setting->dashboard_code_before_body != null)
        {!! $setting->dashboard_code_before_body !!}
    @endif

    @auth()
        @if (auth()->user()->isAdmin())
            <script src="{{ custom_theme_url('/assets/js/panel/update-check.js') }}"></script>
        @endif
    @endauth

    <script src="{{ custom_theme_url('/assets/libs/introjs/intro.min.js') }}"></script>
    <script src="{{ custom_theme_url('assets/js/chatbot.js') }}"></script>

    <template id="typing-template">
        <div
            class="lqd-typing relative inline-flex items-center gap-3 rounded-full bg-secondary !px-3 !py-2 text-xs font-medium leading-none text-secondary-foreground">
            {{ __('Typing') }}
            <div class="lqd-typing-dots flex h-5 items-center gap-1">
                <span class="lqd-typing-dot inline-block !h-1 !w-1 rounded-full !bg-current opacity-40 ![animation-delay:0.2s]"></span>
                <span class="lqd-typing-dot inline-block !h-1 !w-1 rounded-full !bg-current opacity-60 ![animation-delay:0.3s]"></span>
                <span class="lqd-typing-dot inline-block !h-1 !w-1 rounded-full !bg-current opacity-80 ![animation-delay:0.4s]"></span>
            </div>
        </div>
    </template>

    @includeIf('panel.layout.before-body-close')

    @includeIf('seo-tool::particles.generate-seo-script')

    @livewireScriptConfig()

    @include('panel.layout.includes.lazy-intercom')

    @include('panel.layout.includes.subscription-status')
</body>

</html>
