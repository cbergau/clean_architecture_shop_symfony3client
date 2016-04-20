<?php

namespace BwsShop\Ui\Pages;

use RemoteWebDriver;

class PageFactory
{
    private static $baseUrl;

    public static function setBaseUrl($baseUrl)
    {
        static::$baseUrl = $baseUrl;
    }

    /**
     * @param RemoteWebDriver   $driver
     * @param string            $name
     *
     * @return Page
     */
    public function getPage($driver, $name)
    {
        $className = 'BwsShop\Ui\Pages\\' . $name;

        /** @var Page $page */
        $page = new $className($driver, static::$baseUrl);

        return $page;
    }
}
