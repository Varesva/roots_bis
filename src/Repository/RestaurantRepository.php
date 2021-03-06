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

    public function findByCategRestau(int $categId)
    {
        return $this->createQueryBuilder('r')
            ->join('r.categorie', 'c')
            ->setParameter('categId', $categId)
            ->where('c.id = :categId')
            // ->andWhere('s.exampleField = :val')
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(20)
            ->getQuery()
            ->getResult();
    }

    public function findByLocation( $query)
    {
        $qb = $this->createQueryBuilder('r');
        $qb
            ->setParameter('query', '%' . $query . '%')

            ->where(
                $qb->expr()->andX(
                    $qb->expr()->orX(
                        $qb->expr()->like('r.ville', ':query'),
                        $qb->expr()->like('r.code_postal', ':query'),
                    ),
                )
            );

        return $qb
            ->setMaxResults(20)
            ->getQuery()
            ->getResult();
    }

    // RECHERCHE NOM, SPECIALITE, NUTRITION, (CATEGORIE):pas sure
    public function findByQuery( $query)
    {
        $qb = $this->createQueryBuilder('r');
        $qb
            ->join('r.specialite', 's')
            ->join('r.nutrition', 'n')
            // ->andWhere('s.pays = :query')
            ->setParameter('query', '%' . $query . '%')
            // ->where('r.ville = :query')

            ->where(
                $qb->expr()->andX(
                    $qb->expr()->orX(
                        $qb->expr()->like('r.nom', ':query'),
                        // specialite
                        $qb->expr()->like('s.pays', ':query'),
                        // nutrition
                        $qb->expr()->like('n.regime', ':query'),
                    ),
                )
            );


        return $qb
            ->setMaxResults(20)
            ->getQuery()
            ->getResult();
    }

    public function findByNutrition()
    {
        return $this->createQueryBuilder('r')
            ->join('r.nutrition', 'n')
            // ->setParameter('nutriId', $nutriId)
            // ->where('n.regime = :nutriId')
            // ->andWhere('s.exampleField = :val')
            ->orderBy('n.regime', 'ASC')
            ->getQuery()
            ->getResult();
    }



    // public function findByExampleField($value)
    // {
    //     return $this->createQueryBuilder('s')
    //         ->andWhere('s.exampleField = :val')
    //         ->setParameter('val', $value)
    //         ->orderBy('s.id', 'ASC')
    //         ->setMaxResults(10)
    //         ->getQuery()
    //         ->getResult()
    //     ;
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
}
