<?php

namespace BwsShop\Ui\Pages;

class StartPage extends Page
{
    const URL = '/shop';

    public function open()
    {
        $this->openUrl(self::URL);
    }

    /**
     * @param int $index
     */
    public function selectArticleByIndex($index = 0)
    {
        $driver = $this->driver;
        $baseUrl = $this->baseUrl;

        $element = $driver->findElements(\WebDriverBy::cssSelector('.article-title'))[$index];

        $wait = new \WebDriverWait($this->driver, 10, 100);
        $wait->until(\WebDriverExpectedCondition::visibilityOf($element));

        $driver->getMouse()->mouseMove($element->getCoordinates());
        $driver->getMouse()->click($element->getCoordinates());

        $wait = new \WebDriverWait($driver, 10, 100);
        $wait->until(function() use ($driver, $baseUrl) {
            return false !== strpos($driver->getCurrentURL(), $baseUrl . static::URL . '/article/');
        });
    }
}
