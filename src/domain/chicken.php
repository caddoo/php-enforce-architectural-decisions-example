<?php
declare(strict_types=1);

namespace domain;

final class chicken {

    private int $chickenId;

    public function __construct(int $chickenId)
    {
        $this->chickenId = $chickenId;
    }

    public function layEgg(): void
    {
        return;
    }
}