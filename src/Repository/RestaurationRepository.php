<?php

namespace App\Repository;

use App\Entity\Restauration;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Restauration|null find($id, $lockMode = null, $lockVersion = null)
 * @method Restauration|null findOneBy(array $criteria, array $orderBy = null)
 * @method Restauration[]    findAll()
 * @method Restauration[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RestaurationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Restauration::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Restauration $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Restauration $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return Restauration[] Returns an array of Restauration objects
    //  */

    // public function findByCaribRestaurant(int $id)
    // {
    //     $entityManager = $this->getEntityManager();
    //     $caribRestaurant = $entityManager->createQuery(
    //         'SELECT c
    //         FROM App\Entity\Restauration c
    //         WHERE c.id :2
    //         ORDER BY c.id ASC'
    //     )->setParameter('id', $id);

    //     return $caribRestaurant->getResult();
            // return $this->createQueryBuilder('c')

            //     ->andWhere('c.id = :2')
            //     ->setParameter('2', $type_cuisine)
            //     ->orderBy('r.id', 'ASC')
            //     ->setMaxResults(10)
            //     ->getQuery()
            //     ->getResult()
    //     ;
    // }


    /*
    public function findOneBySomeField($value): ?Restauration
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
