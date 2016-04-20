<?php

namespace BwsShop\Ui\Pages;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Log\LoggerInterface;
use RemoteWebDriver;
use WebDriverCapabilityType;
use Exception;

class UiTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @var RemoteWebDriver
     */
    protected $driver;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    protected function setUp()
    {
        parent::setUp();
        $this->logger = new Logger('name');
        $this->logger->pushHandler(new StreamHandler('php://output', Logger::WARNING));

        $this->driver = RemoteWebDriver::create(getenv('HUB_URL'), new \DesiredCapabilities(array(
            WebDriverCapabilityType::BROWSER_NAME => getenv('BROWSER')
        )));
    }

    protected function onNotSuccessfulTest(Exception $e)
    {
        $this->logger->critical($this->driver->getPageSource());
        $this->driver->quit();
        parent::onNotSuccessfulTest($e);
    }
}
