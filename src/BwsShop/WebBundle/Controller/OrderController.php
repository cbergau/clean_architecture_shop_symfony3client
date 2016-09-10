<?php

namespace BwsShop\WebBundle\Controller;

use Bws\Usecase\ShowOrders\ShowOrdersInteractor;
use Bws\Usecase\SubmitOrder\SubmitOrder;
use Bws\Usecase\SubmitOrder\SubmitOrderAsRegisteredCustomerRequest;
use Bws\Usecase\SubmitOrder\SubmitOrderAsUnregisteredCustomerRequest;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class OrderController extends Controller
{
    public function submitUnregisteredAction(Request $request)
    {
        $session = $request->getSession();
        $submitOrderRequest = new SubmitOrderAsUnregisteredCustomerRequest();
        $submitOrderRequest->invoiceFirstName = (string)$request->get('invoiceFirstName');
        $submitOrderRequest->invoiceLastName = (string)$request->get('invoiceLastName');
        $submitOrderRequest->invoiceStreet = (string)$request->get('invoiceStreetHouseNumber');
        $submitOrderRequest->invoiceZip = (string)$request->get('invoiceZip');
        $submitOrderRequest->invoiceCity = (string)$request->get('invoiceCity');
        $submitOrderRequest->birthday = sprintf('%d-%d-%d',
            $request->get('invoiceBirthdayYear'),
            $request->get('invoiceBirthdayMonth'),
            $request->get('invoiceBirthdayDay')
        );
        $submitOrderRequest->emailAddress = (string)$request->get('email');
        $submitOrderRequest->deliveryFirstName = (string)$request->get('deliveryFirstName');
        $submitOrderRequest->deliveryLastName = (string)$request->get('deliveryLastName');
        $submitOrderRequest->deliveryStreet = (string)$request->get('deliveryStreetHouseNumber');
        $submitOrderRequest->deliveryZip = (string)$request->get('deliveryZip');
        $submitOrderRequest->deliveryCity = (string)$request->get('deliveryCity');
        $submitOrderRequest->basketId = $session->get('basketId', null);
        $submitOrderRequest->paymentMethodId = (int)$request->get('paymentMethodId');
        $submitOrderRequest->logisticPartnerId = (int)$request->get('logisticPartnerId');
        $submitOrderRequest->registering = (bool)$request->get('registering');

        /** @var SubmitOrder $interactor */
        $interactor = $this->get('interactor.submit_order');
        $response = $interactor->asUnregisteredCustomer($submitOrderRequest);

        $session->set('orderId', $response->getOrderId());
        $session->set('basketId', 0);

        return $this->redirect($this->generateUrl('bws_shop_web_thanks'));
    }

    public function submitRegisteredAction(Request $httpRequest)
    {
        $request = new SubmitOrderAsRegisteredCustomerRequest();
        $request->customerId = $httpRequest->getSession()->get('customerId');
        $request->basketId = $httpRequest->getSession()->get('basketId');
        $request->logisticPartnerId = $httpRequest->get('logisticPartnerId');
        $request->paymentMethodId = $httpRequest->get('paymentMethodId');
        $request->selectedDelivery = $httpRequest->getSession()->get('selectedDeliveryAddressId');

        /** @var SubmitOrder $interactor */
        $interactor = $this->get('interactor.submit_order');
        $response = $interactor->asRegisteredCustomer($request);

        //@todo presenter and dont throw exception....
        switch ($response->getCode()) {
            case $response::SUCCESS:
                $httpRequest->getSession()->set('orderId', $response->getOrderId());
                $httpRequest->getSession()->set('basketId', 0);
                return $this->redirect($this->generateUrl('bws_shop_web_thanks'));
            default:
                throw new \Exception($response->getMessage() . $response->getCode());
        }
    }

    public function thanksAction(Request $request)
    {
        return $this->render(
            'BwsShopWebBundle:Order:thanks.html.twig',
            array('orderId' => $request->getSession()->get('orderId'))
        );
    }

    public function listAction(Request $request)
    {
        /** @var ShowOrdersInteractor $interactor */
        $interactor = $this->get('interactor.show_orders');
        $response = $interactor->execute($request->getSession()->get('customerId'));

        return $this->render(
            'BwsShopWebBundle:Order:list.html.twig',
            array('orders' => $response->presentableOrders)
        );
    }
}
