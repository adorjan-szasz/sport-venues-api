<?php

namespace App\Repository;

use App\Entity\SportVenue;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Exception;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SportVenue>
 */
class SportVenueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SportVenue::class);
    }

    //    /**
    //     * @return SportVenue[] Returns an array of SportVenue objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('s.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?SportVenue
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    /**
     *  Find sport venues within $km kilometers from ($lat, $lng).
     *
     *  Returns an array of arrays: ['id'=> '', 'name'=> '', 'lat'=> '', 'lng'=> '', 'distance'=> '']
     *
     *  Using the Haversine formula (Earth radius = 6371 km). Runs entirely in SQL for speed.
     *
     * @param float $lat
     * @param float $lng
     * @param float $km
     * @param int $limit
     *
     * @return array
     *
     * @throws Exception
     */
    public function findWithinDistance(float $lat, float $lng, float $km, int $limit = 1000): array
    {
        $conn = $this->getEntityManager()->getConnection();

        // Haversine formula in SQL.
        $sql = <<<SQL
            SELECT id, name, lat, lng,
              (6371 * 2 * ASIN(
                  SQRT(
                    POWER(SIN(RADIANS(CAST(lat AS DOUBLE) - :lat)/2), 2) +
                    COS(RADIANS(:lat)) * COS(RADIANS(CAST(lat AS DOUBLE))) *
                    POWER(SIN(RADIANS(CAST(lng AS DOUBLE) - :lng)/2), 2)
                  )
              )) AS distance
            FROM sport_venue
            HAVING distance <= :km
            ORDER BY distance ASC
            LIMIT :limit
            SQL;

        $stmt = $conn->prepare($sql);

        $stmt->bindValue('lat', $lat);
        $stmt->bindValue('lng', $lng);
        $stmt->bindValue('km', $km);
        $stmt->bindValue('limit', $limit, \PDO::PARAM_INT);

        return $stmt->executeQuery()->fetchAllAssociative();
    }
}
