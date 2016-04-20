<?php

namespace BwsShop\Ui\Pages;

use RemoteWebDriver;

class Page
{
    /** @var RemoteWebDriver */
    protected $driver;

    /** @var string */
    protected $baseUrl;

    /**
     * @param RemoteWebDriver $driver
     * @param string          $baseUrl
     */
    public function __construct(RemoteWebDriver $driver, $baseUrl)
    {
        $this->driver  = $driver;
        $this->baseUrl = $baseUrl;
    }

    /**
     * @param string $url
     */
    public function openUrl($url)
    {
        echo "OPENING URL: " . $this->baseUrl . $url;
        $this->driver->get($this->baseUrl . $url);
    }
}
