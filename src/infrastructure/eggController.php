<?php
declare(strict_types=1);

namespace infrastructure;

final class eggController extends baseController
{
    private eggHandler $eggHandler;

    public function __construct(eggHandler $eggHandler)
    {
        $this->eggHandler = $eggHandler;
    }

    public function LayEgg(int $chickenId): void
    {
        $command = new eggCommand($chickenId);
        $this->eggHandler->handle($command);
    }
}