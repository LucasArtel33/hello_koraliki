<?php

namespace AppBundle\Repository;

/**
 * OrdersRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class OrdersRepository extends \Doctrine\ORM\EntityRepository
{
    public function findOrderByUser($userId)
    {
        $qb = $this->createQueryBuilder('o');

        $qb->leftJoin('o.products','product')
            ->where('o.statusOrder = 1')
            ->andWhere('o.user = :userId')
            ->setParameter('userId', $userId)
            ->addSelect('product');

        $query = $qb->getQuery();

        $result = $query->getOneOrNullResult();

        return $result;
    }

    public function findOrderByCookie($cookie)
    {
        $qb = $this->createQueryBuilder('o');

        $qb->leftJoin('o.products','product')
            ->where('o.statusOrder = 1')
            ->andWhere('o.cookieId = :cookieId')
            ->setParameter('cookieId', $cookie)
            ->addSelect('product');

        $query = $qb->getQuery();

        $result = $query->getOneOrNullResult();

        return $result;
    }

    public function findProductByOrder($userId)
    {
        $qb = $this->createQueryBuilder('o');

        $qb->leftJoin('o.products','product')
            ->where('o.statusOrder = 1')
            ->andWhere('o.user = :userId')
            ->setParameter('userId', $userId)
            ->addSelect('product');

        $query = $qb->getQuery();

        $result = $query->getOneOrNullResult();

        return $result;
    }

}


