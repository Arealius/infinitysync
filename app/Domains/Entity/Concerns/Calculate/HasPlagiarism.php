<?php

declare(strict_types=1);

namespace App\Domains\Entity\Concerns\Calculate;

use Exception;
use Illuminate\Support\Str;

trait HasPlagiarism
{
    /**
     * @throws Exception
     */
    public function calculate(): float
    {
        $wordCount = Str::of($this->getInput())->wordCount();

        return $wordCount * $this->getCreditIndex();
    }
}
