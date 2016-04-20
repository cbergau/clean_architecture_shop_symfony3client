<?php

namespace BwsShop\Ui\Tests;

use BwsShop\Ui\Pages\UiTestCase;
use BwsShop\Ui\Pages\PageFactory;
use BwsShop\Ui\Pages\StartPage;

class SubmitOrderAsUnregisteredCustomer extends UiTestCase
{
    public function testSubmitOrderAsUnregisteredCustomer()
    {
        $pageFactory = new PageFactory();

        /** @var StartPage $startPage */
        $startPage = $pageFactory->getPage($this->driver, 'StartPage');
        $startPage->open();
        $startPage->selectArticleByIndex(0);
    }
}
