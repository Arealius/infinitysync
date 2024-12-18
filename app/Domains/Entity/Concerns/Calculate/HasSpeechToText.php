<?php

declare(strict_types=1);

namespace App\Domains\Entity\Concerns\Calculate;

use Illuminate\Support\Str;

trait HasSpeechToText
{
    public function calculate(): float
    {
        $wordCount = Str::of($this->getInput())->wordCount();

        return $wordCount * $this->getCreditIndex();
    }
}
