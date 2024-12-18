<?php

namespace App\Livewire;

use App\Domains\Engine\Enums\EngineEnum;
use App\Domains\Entity\Enums\EntityEnum;
use Illuminate\View\View;
use Livewire\Component;

class AssignViewCredits extends Component
{
    public array $entities = [];

    public array $enabledAiEngines = [];

    public function mount(array $entities = []): void
    {
        $this->entities = $entities;
        $this->enabledAiEngines = EngineEnum::whereHasEnabledModels();
    }

    public function rules(): array
    {
        return EngineEnum::rules('entities.', ['sometimes|numeric|min:0', 'sometimes|boolean']);
    }

    public function messages(): array
    {
        return collect($this->enabledAiEngines)->flatMap(function (EngineEnum $engine) {
            return collect($engine->models())->mapWithKeys(function (EntityEnum $model) use ($engine) {
                return [
                    "entities.{$engine->slug()}.{$model->slug()}.credit.numeric"      => str_replace(':aiModel', $model->value, 'The :aiModel credit must be a valid number.'),
                    "entities.{$engine->slug()}.{$model->slug()}.credit.min"          => str_replace(':aiModel', $model->value, 'The :aiModel credit must be at least :min.'),
                    "entities.{$engine->slug()}.{$model->slug()}.isUnlimited.boolean" => str_replace(':aiModel', $model->value, 'The :aiModel boolean value must be true or false.'),
                ];
            });
        })->toArray();
    }

    public function updateEntities($key, $value): void
    {
        $this->validate();
        $this->dispatch('updateEntities', $key, $value);
    }

    public function render(): View
    {
        return view('livewire.assign-view-credits');
    }
}
