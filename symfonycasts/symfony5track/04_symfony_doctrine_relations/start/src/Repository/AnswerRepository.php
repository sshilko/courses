<?php

namespace App\Repository;

use App\Entity\Answer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Answer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Answer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Answer[]    findAll()
 * @method Answer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnswerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Answer::class);
    }

    public static function createApprovedCriteria(): Criteria
    {
        return Criteria::create()
            ->andWhere(Criteria::expr()->eq('status', Answer::STATUS_APPROVED));
    }

    /**
     * @param int $max
     * @return Answer[]
     */
    public function findAllApproved(int $max = 10): array
    {
        return $this->createQueryBuilder('a')
            /**
             * Criteria is reusable in DQL builder
             */
            ->addCriteria(self::createApprovedCriteria())
            ->setMaxResults($max)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Answer[]
     */
    public function findMostPopular(?string $search = null): array
    {
        $qb = $this->createQueryBuilder('a')
            ->addCriteria(self::createApprovedCriteria())
            ->orderBy('a.votes', 'DESC')
            #no need to provide more info, doctrine figures out how to write SQL
            #just join is not enough, need to specify what to SELECT from joined table
            ->innerJoin('a.question', 'q')
            #tells to grab everything, but will have question data preloaded fully
            #but method still returns array of Answer objects
            ->addSelect('q');

        if ($search) {
            $qb->andWhere('a.content LIKE :search OR q.question LIKE :search')
                ->setParameter('search', '%' . $search . '%');
        }

        return $qb->setMaxResults(10)->getQuery()->getResult();
    }

    // /**
    //  * @return Answer[] Returns an array of Answer objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Answer
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
