@auth
    @if (auth()->user()->isAdmin())
        <x-alert
            class="top-notice-bar items-center rounded-none py-1 text-xs shadow-none"
            id="top-notice-bar"
            variant="warn-fill"
            icon="tabler-info-circle"
            size="xs"
            x-data="{ noticeBarHidden: localStorage.getItem('lqdTopBarNotice') === 'hidden' }"
            ::class="{ 'hidden': noticeBarHidden }"
        >
            <script>
                if (localStorage.getItem('lqdTopBarNotice') === 'hidden') {
                    document.getElementById('top-notice-bar').style.display = 'none';
                }
            </script>
            <div class="flex w-full grow items-center justify-between gap-2">
                <p class="m-0">We've revamped the plan management system to give you full control over your pricing strategies. You may need to review and update your pricing plans.</p>
                <x-button
                    class="bg-background px-2.5 py-1 text-xs text-heading-foreground hover:bg-primary hover:text-primary-foreground"
                    size="sm"
                    @click="localStorage.setItem('lqdTopBarNotice', 'hidden'); noticeBarHidden = true;"
                    href="{{ route('dashboard.admin.finance.plan.index') }}"
                >
                    {{ __("See What's New") }}
                </x-button>
            </div>
        </x-alert>
    @endif
@endauth
