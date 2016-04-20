<?php

namespace Bws\DoctrineBundle\Entity;

use Bws\Entity\DeliveryAddress as BaseDeliveryAddress;
use Bws\Repository\DeliveryAddressRepository as BaseDeliveryAddressRepository;
use Doctrine\ORM\EntityRepository;

class DeliveryAddressRepository extends EntityRepository implements BaseDeliveryAddressRepository
{
    /**
     * @param BaseDeliveryAddress $deliveryAddress
     */
    public function save(BaseDeliveryAddress $deliveryAddress)
    {
        $this->getEntityManager()->persist($deliveryAddress);
        $this->getEntityManager()->flush();
    }

    /**
     * @return DeliveryAddress
     */
    public function factory()
    {
        return new DeliveryAddress();
    }

    public function findExisting($firstName, $lastName, $street, $zip, $city)
    {
        $result = $this
            ->getEntityManager()
            ->createQueryBuilder()
            ->select('d')
            ->from('Bws\DoctrineBundle\Entity\DeliveryAddress', 'd')
            ->where('d.firstName = :firstName')
            ->andWhere('d.lastName = :lastName')
            ->andWhere('d.street = :street')
            ->andWhere('d.zip = :zip')
            ->andWhere('d.city = :city')
            ->orderBy('d.id', 'desc')
            ->setParameter('firstName', $firstName)
            ->setParameter('lastName', $lastName)
            ->setParameter('street', $street)
            ->setParameter('zip', $zip)
            ->setParameter('city', $city)
            ->setMaxResults(1)
            ->getQuery()
            ->getResult();

        $invoiceAddress = isset($result[0]) ? $result[0] : null;

        return $invoiceAddress;
    }
}
