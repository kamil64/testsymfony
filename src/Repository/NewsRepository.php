<?php

namespace App\Repository;

use App\Entity\News;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<News>
 *
 * @method News|null find($id, $lockMode = null, $lockVersion = null)
 * @method News|null findOneBy(array $criteria, array $orderBy = null)
 * @method News[]    findAll()
 * @method News[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NewsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, News::class);
    }

    /**
     * @return News[]
     */
    public function getAllOrdered(): array
    {
        return $this->createQueryBuilder('n')
            ->orderBy('n.date', 'DESC')
            ->getQuery()
            ->execute();
    }

    /**
     * @param News $entity
     * @param bool $persist
     * @return void
     */
    public function save(News $entity, bool $persist = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($persist) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param News $entity
     * @param bool $persist
     * @return void
     */
    public function delete(News $entity, bool $persist = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($persist) {
            $this->getEntityManager()->flush();
        }
    }
}
