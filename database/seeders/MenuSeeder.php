<?php

namespace Database\Seeders;

use App\Domains\Marketplace\Repositories\Contracts\ExtensionRepositoryInterface;
use App\Models\Common\Menu;
use App\Services\Common\MenuService;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        $items = (new MenuService)->data();

        foreach ($items as $item) {
            Menu::query()
                ->firstOrCreate([
                    'key' => data_get($item, 'key'),
                ], [
                    'parent_id'      => Menu::query()->where('key', data_get($item, 'parent_key'))->value('id'),
                    'route'          => data_get($item, 'route'),
                    'route_slug'     => data_get($item, 'route_slug'),
                    'label'          => data_get($item, 'label'),
                    'icon'           => data_get($item, 'icon'),
                    'svg'            => data_get($item, 'svg'),
                    'order'          => data_get($item, 'order'),
                    'is_active'      => data_get($item, 'is_active'),
                    'params'         => data_get($item, 'params'),
                    'type'           => data_get($item, 'type'),
                    'extension'      => data_get($item, 'extension'),
                    'letter_icon'    => data_get($item, 'letter_icon'),
                    'letter_icon_bg' => data_get($item, 'letter_icon_bg'),
                ]);
        }

        if (app(ExtensionRepositoryInterface::class)->appVersion() == 7.3) {
            Menu::query()
                ->where('parent_id', null)
                ->whereHas('children')
                ->get()->map(function ($item) {
                    $item->children()
                        ->where('parent_id', $item['id'])
                        ->where('custom_menu', false)
                        ->update([
                            'icon' => null,
                        ]);
                });
        }

        app(MenuService::class)->regenerate();
    }
}
