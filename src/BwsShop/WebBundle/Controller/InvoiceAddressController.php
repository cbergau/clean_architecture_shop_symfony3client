<?php

namespace BwsShop\WebBundle\Controller;

use Bws\Interactor\ChangeInvoiceAddressRequest;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;

class InvoiceAddressController extends FOSRestController
{
    /**
     * @View
     *
     * @param Request $httpRequest
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function changeAction(Request $httpRequest)
    {
        $request             = new ChangeInvoiceAddressRequest();
        $request->customerId = (int)$httpRequest->getSession()->get('customerId');
        $request->firstName  = (string)$httpRequest->get('first_name');
        $request->lastName   = (string)$httpRequest->get('last_name');
        $request->street     = (string)$httpRequest->get('street');
        $request->zip        = (string)$httpRequest->get('zip');
        $request->city       = (string)$httpRequest->get('city');

        $result = $this->get('interactor.change_invoice_address')->execute($request);

        switch ($result->code) {
            case $result::SUCCESS:
                $view = $this->view('ok', 200)->setTemplateVar('result');
                break;
            default:
                $view = $this->view('Internal Server Error', 500)->setTemplateVar('result');
                break;
        }

        return $this->handleView($view);
    }
}
