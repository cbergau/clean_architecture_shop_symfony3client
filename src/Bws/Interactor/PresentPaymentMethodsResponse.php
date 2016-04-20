<?php

namespace Bws\Interactor;

class PresentPaymentMethodsResponse
{
    /**
     * @var array
     */
    private $paymentMethods = array();

    public function __construct(array $paymentMethods)
    {
        $this->paymentMethods = $paymentMethods;
    }

    /**
     * @return array
     */
    public function getPaymentMethods()
    {
        return $this->paymentMethods;
    }
}
