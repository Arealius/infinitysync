<table class="mb-4 w-full table-auto border-collapse border">
    <thead>
    <tr class="bg-foreground/10">
        <th class="border p-2 text-left">{{ __('Model') }}</th>
        <th class="border p-2 text-right">{{ __('Credits') }}</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($categories as $key => $model)
        @php
                $drivers = $plan->exists ? $model->forPlan($plan)->list() : $model->forUser(auth()->user())->list();
                $groupName = $drivers->isNotEmpty() ? $drivers->first()->enum()->subLabel() : '';
                $isUnlimited = $model->checkIfThereUnlimited();
                $credits = $model->totalCredits();
        @endphp
        @if(!$isUnlimited && $credits <= 0)
            @continue
        @endif
        <tr>
            <td class="border p-2">{{ $groupName }}</td>
            <td class="border p-2 text-right">
                {{ $isUnlimited ? __('Unlimited') : $credits }}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
