<?php

namespace BwsDoctrineBundle\Entity;

use Bws\Repository\PaymentMethodRepositoryInterface;
use Doctrine\ORM\EntityRepository;

class PaymentMethodRepository extends EntityRepository implements PaymentMethodRepositoryInterface
{
}
