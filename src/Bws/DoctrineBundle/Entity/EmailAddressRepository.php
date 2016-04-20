<?php

namespace Bws\DoctrineBundle\Entity;

use Bws\Entity\EmailAddress as BaseEmailAddress;
use Bws\Repository\EmailAddressRepository as BaseEmailAddressRepository;
use Doctrine\ORM\EntityRepository;

class EmailAddressRepository extends EntityRepository implements BaseEmailAddressRepository
{
    /**
     * @return EmailAddress
     */
    public function factory()
    {
        return new EmailAddress();
    }

    public function save(BaseEmailAddress $emailAddress)
    {
        $this->getEntityManager()->persist($emailAddress);
        $this->getEntityManager()->flush();
    }

    /**
     * @param string $address
     *
     * @return BaseEmailAddress|null
     */
    public function findByAddress($address)
    {
        $result = $this->findBy(array('address' => $address));
        return isset($result[0]) ? $result[0] : null;
    }
}
