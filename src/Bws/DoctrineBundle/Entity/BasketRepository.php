<?php

namespace Bws\DoctrineBundle\Entity;

use Bws\Entity\Basket as BaseBasket;
use Bws\Repository\BasketRepository as BaseBasketRepository;
use Doctrine\ORM\EntityRepository;

class BasketRepository extends EntityRepository implements BaseBasketRepository
{
    /**
     * @param BaseBasket $basket
     */
    public function save(BaseBasket $basket)
    {
        $this->getEntityManager()->persist($basket);
        $this->getEntityManager()->flush();
    }

    /**
     * @return BaseBasket
     */
    public function factory()
    {
        return new Basket();
    }
}
