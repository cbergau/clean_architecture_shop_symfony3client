<?php

namespace Bws\Interactor;

class SubmitOrderAsRegisteredCustomerRequest
{
    public $customerId;
    public $selectedDelivery;
    public $logisticPartnerId;
    public $paymentMethodId;
    public $basketId;
}
