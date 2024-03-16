<?php

declare(strict_types=1);

namespace App\Item\Infrastructure\Doctrine\Repository;

use App\Item\Domain\Model\Item;
use App\Item\Domain\Repository\ItemRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

class ItemDoctrineRepository extends ServiceEntityRepository implements ItemRepository
{
    private EntityManagerInterface $em;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Item::class);
        $this->em = $this->getEntityManager();
    }

    /** @param Item[] $items */
    public function saveMultiple(array $items): void
    {
        $batchSize = 100;
        foreach ($items as $i => $item) {
            $this->em->persist($item);
            if (($i % $batchSize) === 0) {
                $this->flushAndClear();
            }
        }

        $this->flushAndClear();
    }

    public function findById(int $id): ?Item
    {
        return parent::find($id);
    }

    private function flushAndClear(): void
    {
        $this->em->flush();
        $this->em->clear();
    }
}