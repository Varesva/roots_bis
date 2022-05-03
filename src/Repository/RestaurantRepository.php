<?php

namespace App\Repository;

use App\Entity\Restaurant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Restaurant|null find($id, $lockMode = null, $lockVersion = null)
 * @method Restaurant|null findOneBy(array $criteria, array $orderBy = null)
 * @method Restaurant[]    findAll()
 * @method Restaurant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RestaurantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Restaurant::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Restaurant $entity, bool $flush = true): void
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
    public function remove(Restaurant $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return Restaurant[] Returns an array of Restauration objects
    //  */

    // public function findByCaribRestaurant()
    // {
    //     $query = $this ->createQueryBuilder('c');
    //     $query->where('c=2');
    //     $restauration = $this->getEntityManager();
    //     $caribRestaurant = $entityManager->createQuery(
    //         'SELECT r
    //         FROM App\Entity\Restaurant r
    //         WHERE r.id :2
    //         ORDER BY r.id ASC'
    //     )->setParameter('restauration', $restauration);

    //     return $caribRestaurant->getResult();

    // return $this->createQueryBuilder('c')

    //         //     ->andWhere('c.id = :2')
    //         //     ->setParameter('2', $type_cuisine)
    //         //     ->orderBy('r.id', 'ASC')
    //         //     ->setMaxResults(10)
    //         //     ->getQuery()
    //         //     ->getResult()
    //     ;
    // }

    // public function findByCaribRestaurant(int $restauration): array
    // {
    //     $entityManager = $this->getEntityManager();

    //     $query = $entityManager->createQuery(
    //         'SELECT c
    //         FROM App\Entity\Restaurant c
    //         WHERE c.restauration :2
    //         ORDER BY c.restauration ASC'
    //     )->setParameter('restauration', $restauration);

    //     // returns an array of Product objects
    //     return $query->getResult();
    // }


    /*
    public function findOneBySomeField($value): ?Restaurant
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    // /**
    //  * @return Restauration[] Returns an array of Restauration objects
    //  */
    
    // public function findByCaribRestaurant(int $restauration_id)
    // {
    //     return $this->createQueryBuilder('c')
    //     ->andWhere('c.restauration_id = :?2')
    //     ->setParameter('restauration_id', $restauration_id)
    //     ->orderBy('c.id', 'ASC')
    //         ->setMaxResults(10)
    //         ->getQuery()
    //         ->getResult()
    //     ;
    // }
    
}
