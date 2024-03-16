<?php

declare(strict_types=1);

namespace App\Tests\Integration;

use Behat\Behat\Context\Context;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManagerInterface;

class FeatureContext implements Context
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    /** @AfterScenario */
    public function clearData(): void
    {
        $purger = new ORMPurger($this->entityManager);
        $purger->setPurgeMode(ORMPurger::PURGE_MODE_TRUNCATE);
        $purger->purge();
    }
}