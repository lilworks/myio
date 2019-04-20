<?php

namespace App\Repository;

use App\Entity\IoFile;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method IoFile|null find($id, $lockMode = null, $lockVersion = null)
 * @method IoFile|null findOneBy(array $criteria, array $orderBy = null)
 * @method IoFile[]    findAll()
 * @method IoFile[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IoFileRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, IoFile::class);
    }

    // /**
    //  * @return IoFile[] Returns an array of IoFile objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?IoFile
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
