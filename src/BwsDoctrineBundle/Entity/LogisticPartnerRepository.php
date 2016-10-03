<?php

namespace BwsDoctrineBundle\Entity;

use Bws\Repository\LogisticPartnerRepositoryInterface;
use Doctrine\ORM\EntityRepository;

class LogisticPartnerRepository extends EntityRepository implements LogisticPartnerRepositoryInterface
{
}
