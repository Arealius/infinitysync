<div class="space-y-8">
    @foreach ($enabledAiEngines as $aiEngine)
        @if (isset($entities[$aiEngine->value]))
            <x-form-step
                class="-mb-2"
                step="{{ $loop->iteration }}"
                label="{{ $aiEngine->label() }}"
            />

            <div class="w-full space-y-5">
                @php
                    $defaultModels = $aiEngine->getDefaultModels($setting, $settings_two);
                    $modelsWithoutDefault = $aiEngine->getListableActiveModels($setting, $settings_two);
                @endphp

                @foreach ($defaultModels as $defaultModel)
                    <x-form.group
                        class:label="w-2/3"
                        class="space-y-2"
                        tooltip="{{ $defaultModel->label() }}"
                        label="{{ $defaultModel->value }} ({{ $defaultModel->subLabel() }} Model)"
                        :error="'entities.' . $defaultModel->engine()->slug() . '.' . $defaultModel->slug() . '.credit'"
                    >
                        <div class="absolute -top-0.5 end-0 !m-0 lg:top-0">
                            <x-form.checkbox
                                class:input="lg:!h-[18px] lg:!w-[34px] lg:![background-position:10%_50%] lg:![background-size:8px] lg:checked:![background-position:90%_50%]"
                                position="left"
                                wire:model="entities.{{ $defaultModel->engine()->slug() }}.{{ $defaultModel->slug() }}.isUnlimited"
                                wire:change="updateEntities('entities.{{ $defaultModel->engine()->slug() }}.{{ $defaultModel->slug() }}.isUnlimited', $event.target.checked)"
                                name="entities[{{ $defaultModel->engine()->slug() }}][{{ $defaultModel->slug() }}][isUnlimited]"
                                :checked="$entities[$defaultModel->engine()->slug()][$defaultModel->slug()]['isUnlimited'] ?? false"
                                label="{{ __('Unlimited') }}"
                                size="sm"
                            />
                        </div>

                        <div>
                            <x-form.stepper
                                wire:model="entities.{{ $defaultModel->engine()->slug() }}.{{ $defaultModel->slug() }}.credit"
                                wire:input="updateEntities('entities.{{ $defaultModel->engine()->slug() }}.{{ $defaultModel->slug() }}.credit', $event.target.value)"
                                series="entities.{{ $defaultModel->engine()->slug() }}.{{ $defaultModel->slug() }}.credit"
                                name="entities[{{ $defaultModel->engine()->slug() }}][{{ $defaultModel->slug() }}][credit]"
                                size="lg"
                                min="0"
                                step="1"
                            />
                            <small>
                                {{ $defaultModel->tooltipHowToCalc() }}
                            </small>
                        </div>
                    </x-form.group>
                @endforeach

                @if ($modelsWithoutDefault->count() > 0)
                    <div x-data="{ showContent: false }">
                        <x-button
                            class="flex w-full items-center justify-between gap-7 py-3 text-2xs"
                            type="button"
                            variant="link"
                            @click="showContent = !showContent"
                        >
                            <span class="h-px grow bg-current opacity-10"></span>
                            <span class="flex items-center gap-3">
                                {{ __('View All') }}
                                <x-tabler-chevron-up
                                    class="size-4 rotate-180 transition"
                                    ::class="{ 'rotate-0': showContent, 'rotate-180': !showContent }"
                                />
                            </span>
                            <span class="h-px grow bg-current opacity-10"></span>
                        </x-button>
                        <div
                            class="hidden"
                            :class="{ 'hidden': !showContent }"
                        >
                            <div class="space-y-5 pt-5">
								<x-alert variant="danger">
									@lang('These model credits listed below will not be visible to the user and cannot be used until the model is set as the default in the related settings page.')
								</x-alert>
                                @foreach ($modelsWithoutDefault as $entity)
                                    <x-form.group
                                        tooltip="{{ $entity->key->label() }}"
                                        label="{{ $entity->key->value }} ({{ $entity->key->subLabel() }} Model)"
                                        :error="'entities.' . $entity->engine->slug() . '.' . $entity->key->slug() . '.credit'"
                                    >
                                        <div class="absolute -top-0.5 end-0 !m-0 lg:top-0">
                                            <x-form.checkbox
                                                class:input="lg:!h-[18px] lg:!w-[34px] lg:![background-position:10%_50%] lg:![background-size:8px] lg:checked:![background-position:90%_50%]"
                                                position="left"
                                                wire:model="entities.{{ $entity->engine->slug() }}.{{ $entity->key->slug() }}.isUnlimited"
                                                wire:change="updateEntities('entities.{{ $entity->engine->slug() }}.{{ $entity->key->slug() }}.isUnlimited', $event.target.checked)"
                                                name="entities[{{ $entity->engine->slug() }}][{{ $entity->key->slug() }}][isUnlimited]"
                                                :checked="$entities[$entity->engine->slug()][$entity->key->slug()]['isUnlimited'] ?? false"
                                                label="{{ __('Unlimited') }}"
                                            />
                                        </div>

                                        <div>
                                            <x-form.stepper
                                                wire:model="entities.{{ $entity->engine->slug() }}.{{ $entity->key->slug() }}.credit"
                                                wire:input="updateEntities('entities.{{ $entity->engine->slug() }}.{{ $entity->key->slug() }}.credit', $event.target.value)"
                                                name="entities[{{ $entity->engine->slug() }}][{{ $entity->key->slug() }}][credit]"
                                                size="lg"
                                                min="0"
                                                step="1"
                                            />
                                            <small>
                                                {{ $entity->key->tooltipHowToCalc() }}
                                            </small>
                                        </div>
                                    </x-form.group>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        @endif
    @endforeach
</div>
