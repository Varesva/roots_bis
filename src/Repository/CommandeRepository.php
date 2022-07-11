<?php

namespace App\Repository;

use App\Entity\Commande;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Commande|null find($id, $lockMode = null, $lockVersion = null)
 * @method Commande|null findOneBy(array $criteria, array $orderBy = null)
 * @method Commande[]    findAll()
 * @method Commande[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommandeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Commande::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Commande $entity, bool $flush = true): void
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
    public function remove(Commande $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @return Commande[] Returns an array of Commande objects
     */

    // ADMIN - ALL ORDERS
    public function findAllByDesc()
    {
        return $this->createQueryBuilder('c')
            ->orderBy('c.id', 'DESC')
            ->getQuery()
            ->getResult();
    }

    // USER - ALL USER'S ORDERS
    public function findAllOrdersByUser($userId)
    {
        $qb = $this->createQueryBuilder('c')
            ->join('c.user', 'u')
            ->setParameter('userId', $userId)
            ->where('u.id = :userId')
            ->orderBy('c.date', 'DESC')
            ->getQuery()
            ->getResult();

        return $qb;
    }


    public function findOrdersByLC($lcId)
    {
        $qb = $this->createQueryBuilder('c')
            ->join('c.lignes_commande', 'lc')
            ->setParameter('lcId', $lcId)
            ->where('lc.id = :lcId')
            // // ->andWhere('u.id = :val')
            ->getQuery()
            ->getResult();

        return $qb;
    }

    public function findLastOrderRef()
    {
        $qb = $this->createQueryBuilder('c')
            ->setMaxResults(1)
            ->orderBy('c.id', 'DESC')
            ->getQuery()
            ->getResult();

        return $qb;
    }


    
    public function findOneOrder($userId, $id): ?Commande
    {
        return $this->createQueryBuilder('c')
        ->join('c.user', 'u')
        ->setParameter('userId', $userId)
        ->where('u.id = :userId')
        ->andWhere('c.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    


    /*
    public function findOneBySomeField($value): ?Commande
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
