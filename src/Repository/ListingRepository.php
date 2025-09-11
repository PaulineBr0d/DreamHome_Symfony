<?php

namespace App\Repository;

use App\Entity\Listing;
use App\Entity\PropertyType;
use App\Entity\TransactionType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Listing>
 */
class ListingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Listing::class);
    }

    public function search( 
        ?string $city,
        ?PropertyType $propertyType,
        ?TransactionType $transactionType,
        ?float $maxPrice
    ): array {
    $qb = $this->createQueryBuilder('l');

    if ($city) {
        $qb->andWhere('l.city LIKE :city')
           ->setParameter('city', '%' . $city . '%');
    }

     if ($propertyType) {
        $qb->andWhere('l.propertyType = :propertyType')
           ->setParameter('propertyType', $propertyType);
    }

    if ($transactionType) {
        $qb->andWhere('l.transactionType = :transactionType')
           ->setParameter('transactionType', $transactionType);
    }    
    if ($maxPrice) {
        $qb->andWhere('l.price <= :maxPrice')
           ->setParameter('maxPrice', $maxPrice);
    }

    return $qb->getQuery()->getResult();
    }
//    /**
//     * @return Listing[] Returns an array of Listing objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('l.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Listing
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
