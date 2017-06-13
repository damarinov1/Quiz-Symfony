<?php
namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class QuestionsRepository extends EntityRepository
{

    public function findRandomList()
    {
        $ids = $this->createQueryBuilder('q')
            ->select('q.id')
            ->getQuery()
            ->getArrayResult();

        $rand = array_rand($ids, 10);

        return $rand;
    }
}
