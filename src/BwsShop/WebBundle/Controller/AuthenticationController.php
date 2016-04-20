<?php

namespace BwsShop\WebBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\View;
use Symfony\Component\HttpFoundation\Request;

class AuthenticationController extends FOSRestController
{
    public function indexAction(Request $request)
    {
        if ($request->getSession()->get('total') == 0) {
            return $this->render('BwsShopWebBundle:Authentication:basket.empty.html.twig');
        } else {
            if ($request->get('login', false)) {
                $email = $request->get('email');
                $password = $request->get('password');

                $loginInteractor = $this->get('interactor.login');
                $result = $loginInteractor->execute($email, $password);

                if ($result->code == $result::SUCCESS) {
                    $request->getSession()->set('customerId', $result->customerId);
                    $request->getSession()->set('display', $result->display);
                    return $this->redirect($this->generateUrl('bws_shop_web_registered'));
                }
            }

            return $this->render('BwsShopWebBundle:Authentication:index.html.twig');
        }
    }

    /**
     * @View()
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function loginAction(Request $request)
    {
        $email = $request->get('email');
        $password = $request->get('password');

        $interactor = $this->get('interactor.login');
        $result = $interactor->execute($email, $password);

        $code = 400;

        if ($result->code == $result::SUCCESS) {
            $request->getSession()->set('customerId', $result->customerId);
            $request->getSession()->set('display', $result->display);
            $code = 200;
        }

        $view = $this
            ->view($result, $code)
            ->setTemplateVar('response');

        return $this->handleView($view);
    }

    public function logoutAction(Request $request)
    {
        $request->getSession()->set('display', null);
        $request->getSession()->set('customerId', null);
        return $this->redirect($this->generateUrl('bws_shop_web_authentication'));
    }
}
