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

    /**
     * @return Restaurant[] Returns an array of Restaurant objects
    */
    
    public function findByCuisinecarib(string $type_cuisine):array
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery
        (
            'SELECT restauration
            FROM App\Entity\Restauration
            WHERE restauration.type_cuisine = :Cuisines caribéennes
            ORDER BY restauration.type_cuisine ASC'
        )
        ->setParameter('type_cuisine', $type_cuisine)
        ->setMaxResults(15);

        return $query->getResult();

        // return $this->createQueryBuilder('restaurant')
        //     ->andWhere('restaurant.type_cuisine = :Cuisines africaines')
        //     ->setParameter('val', $value)
        //     ->orderBy('restaurant.id', 'ASC')
        //     ->getQuery()
        //     ->getResult()
        
    }


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
}
