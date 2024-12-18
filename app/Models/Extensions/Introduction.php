<?php

namespace App\Models\Extensions;

use Illuminate\Database\Eloquent\Model;

class Introduction extends Model
{
    protected $fillable = ['key', 'intro', 'order'];

    protected $casts = [
        'key' => \App\Enums\Introduction::class,
    ];

    public static function getFormattedSteps()
    {
        return self::orderBy('order')->get()->map(function ($item) {
            return [
                'intro'   => $item->intro,
                'element' => '[data-name="' . $item->key->value . '"]',
            ];
        });
    }
}
