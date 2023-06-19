<?php
declare(strict_types=1);

namespace application;

final class eggCommand {
    private int $chickenId;

    public function __construct(int $chickenId) {
        $this->chickenId = $chickenId;
    }

    public function getChickenId(): int
    {
        return $this->chickenId;
    }
}