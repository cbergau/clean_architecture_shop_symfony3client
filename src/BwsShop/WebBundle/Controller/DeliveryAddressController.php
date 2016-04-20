<?php

namespace BwsShop\WebBundle\Controller;

use Bws\Interactor\AddDeliveryAddressRequest;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;

class DeliveryAddressController extends FOSRestController
{
    /**
     * @View
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction(Request $request)
    {
        $customerId = $request->getSession()->get('customerId');

        $customer  = $this->get('customer.repository')->find($customerId);
        $addresses = $this->get('deliveryaddress.repository')->findBy(array('customer' => $customer));

        $view = $this
            ->view($addresses, 200)
            ->setTemplate('BwsShopWebBundle:Basket:list.html.twig')
            ->setTemplateVar('addresses');

        return $this->handleView($view);
    }

    /**
     * @View
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function selectAction(Request $request)
    {
        $customerId = $request->getSession()->get('customerId');
        $addressId  = $request->get('id');

        $result = $this->get('interactor.delivery_address_selectable')->execute($customerId, $addressId);

        switch ($result->code) {
            case $result::ADDRESS_DOES_NOT_BELONG_TO_GIVEN_CUSTOMER:
                $view = $this->view('forbidden', 403)->setTemplateVar('result');
                break;
            case $result::ADDRESS_IS_SELECTABLE:
                $view = $this->view('ok', 200)->setTemplateVar('result');
                $request->getSession()->set('selectedDeliveryAddressId', $addressId);
                break;
            case $result::ADDRESS_NOT_FOUND:
            case $result::CUSTOMER_NOT_FOUND:
                $view = $this->view('address or customer not found', 500)->setTemplateVar('result');
                break;
            default:
                $view = $this->view('unknown error', 500)->setTemplateVar('result');
                break;
        }

        return $this->handleView($view);
    }

    /**
     * @View
     *
     * @param Request $httpRequest
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addAction(Request $httpRequest)
    {
        $request             = new AddDeliveryAddressRequest();
        $request->customerId = (int)$httpRequest->getSession()->get('customerId');
        $request->firstName  = (string)$httpRequest->get('first_name');
        $request->lastName   = (string)$httpRequest->get('last_name');
        $request->street     = (string)$httpRequest->get('street');
        $request->zip        = (string)$httpRequest->get('zip');
        $request->city       = (string)$httpRequest->get('city');

        $result = $this->get('interactor.add_delivery_address')->execute($request);

        switch ($result->code) {
            case $result::SUCCESS:
                $view = $this->view('ok', 200)->setTemplateVar('result');
                break;
            case $result::ADDRESS_INVALID:
                $view = $this->view($result->messages, 500)->setTemplateVar('result');
                break;
            default:
                $view = $this->view('Internal Server Error', 500)->setTemplateVar('result');
                break;
        }

        return $this->handleView($view);
    }
}
