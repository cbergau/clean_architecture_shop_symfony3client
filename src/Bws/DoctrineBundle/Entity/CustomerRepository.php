<?php

namespace Bws\DoctrineBundle\Entity;

use Bws\Entity\Customer as BaseCustomer;
use Bws\Entity\InvoiceAddress as BaseInvoiceAddress;
use Bws\Repository\CustomerRepository as BaseCustomerRepository;
use Doctrine\ORM\EntityRepository;

class CustomerRepository extends EntityRepository implements BaseCustomerRepository
{
    /**
     * @inheritdoc
     */
    public function factory()
    {
        return new Customer();
    }

    /**
     * @inheritdoc
     */
    public function save(BaseCustomer $customer)
    {
        $this->getEntityManager()->persist($customer);
        $this->getEntityManager()->flush();
    }

    /**
     * @inheritdoc
     */
    public function match(BaseInvoiceAddress $invoiceAddress)
    {
        $result = $this->findBy(array('customerString' => $invoiceAddress->getCustomerString()));
        return isset($result[0]) ? $result[0] : null;
    }
}
