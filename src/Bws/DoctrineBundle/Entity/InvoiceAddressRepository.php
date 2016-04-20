<?php

namespace Bws\DoctrineBundle\Entity;

use Bws\Entity\InvoiceAddress as BaseInvoiceAddress;
use Bws\Repository\InvoiceAddressRepository as BaseInvoiceAddressRepository;
use Doctrine\ORM\EntityRepository;

class InvoiceAddressRepository extends EntityRepository implements BaseInvoiceAddressRepository
{
    /**
     * @param BaseInvoiceAddress $invoiceAddress
     */
    public function save(BaseInvoiceAddress $invoiceAddress)
    {
        $this->getEntityManager()->persist($invoiceAddress);
        $this->getEntityManager()->flush();
    }

    /**
     * @return BaseInvoiceAddress
     */
    public function factory()
    {
        return new InvoiceAddress();
    }

    public function findExisting($firstName, $lastName, $street, $zip, $city)
    {
        $result = $this
            ->getEntityManager()
            ->createQueryBuilder()
            ->select('i')
            ->from('Bws\DoctrineBundle\Entity\InvoiceAddress', 'i')
            ->where('i.firstName = :firstName')
            ->andWhere('i.lastName = :lastName')
            ->andWhere('i.street = :street')
            ->andWhere('i.zip = :zip')
            ->andWhere('i.city = :city')
            ->orderBy('i.id', 'desc')
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
