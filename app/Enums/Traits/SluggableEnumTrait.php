<?php

declare(strict_types=1);

namespace App\Enums\Traits;

trait SluggableEnumTrait
{
    public function slug(): string
    {
        return str_replace('.', '__', $this->value);
    }

    public static function fromSlug(string $value): self
    {
        return self::tryFrom(str_replace('__', '.', $value));
    }
}
