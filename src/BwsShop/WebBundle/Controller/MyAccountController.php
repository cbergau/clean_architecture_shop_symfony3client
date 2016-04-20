<?php

namespace BwsShop\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MyAccountController extends Controller
{
    public function indexAction()
    {
        return $this->render(
            'BwsShopWebBundle:MyAccount:index.html.twig',
            array()
        );
    }
}
