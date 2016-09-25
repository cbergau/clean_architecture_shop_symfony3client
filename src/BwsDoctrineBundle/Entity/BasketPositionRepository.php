<?php

namespace BwsDoctrineBundle\Entity;

use Bws\Entity\Basket as BaseBasket;
use Bws\Entity\BasketPosition as BaseBasketPosition;
use Bws\Repository\BasketPositionRepository as BaseBasketPositionRepository;
use Doctrine\ORM\EntityRepository;

class BasketPositionRepository extends EntityRepository implements BaseBasketPositionRepository
{
    /**
     * @param BaseBasket $basket
     *
     * @return BasketPosition[]
     */
    public function findByBasket(BaseBasket $basket)
    {
        return $this->findBy(array('basket' => $basket));
    }

    /**
     * @param BaseBasketPosition $basketPosition
     */
    public function addToBasket(BaseBasketPosition $basketPosition)
    {
        $this->getEntityManager()->persist($basketPosition);
        $this->getEntityManager()->flush($basketPosition);
    }

    public function removeFromBasket(BaseBasketPosition $basketPosition)
    {
        $this->getEntityManager()->remove($basketPosition);
        $this->getEntityManager()->flush($basketPosition);
    }

    /**
     * @return BasketPosition
     */
    public function factory()
    {
        return new BasketPosition();
    }
}
