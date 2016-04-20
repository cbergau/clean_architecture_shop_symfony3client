<?php

namespace Bws\DoctrineBundle\Entity;

use Bws\Repository\ArticleRepository as BaseArticleRepository;
use Doctrine\ORM\EntityRepository;

class ArticleRepository extends EntityRepository implements BaseArticleRepository
{
    /**
     * @param string $by
     *
     * @return Article[]
     */
    public function search($by)
    {
        return $this
            ->createQueryBuilder('a')
            ->where('a.title LIKE :title')
            ->setParameter('title', '%' . $by . '%')
            ->getQuery()
            ->getResult()
        ;
    }
}
