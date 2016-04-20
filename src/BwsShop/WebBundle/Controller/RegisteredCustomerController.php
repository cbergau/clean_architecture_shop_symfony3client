<?php

namespace BwsShop\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class RegisteredCustomerController extends Controller
{
    public function registeredAction(Request $request)
    {
        $presentCurrentAddress = $this->get('interactor.present_current_address');
        $presentLastUsed       = $this->get('interactor.present_last_used_address');
        $paymentMethods        = $this->get('interactor.present_paymentmethods')->execute()->getPaymentMethods();
        $logisticPartners      = $this->get('interactor.present_logisticpartners')->execute()->getLogisticPartners();

        $selectedDeliveryAddressId = $request->getSession()->get('selectedDeliveryAddressId', null);
        return $this->render(
            'BwsShopWebBundle:RegisteredCustomer:registered.html.twig',
            array(
                'invoice'          => $presentLastUsed->getInvoice($request->getSession()->get('customerId'))->address,
                'delivery'         => $presentCurrentAddress->getCurrentDeliveryAddress(
                        $request->getSession()->get('customerId'),
                        $selectedDeliveryAddressId
                    )->address,
                'paymentMethods'   => $paymentMethods,
                'logisticPartners' => $logisticPartners
            )
        );
    }
}
