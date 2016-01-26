<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\Mink\Mink,
    Behat\Mink\Session,
    Behat\Mink\Driver\GoutteDriver,
    Behat\Mink\Driver\Goutte\Client as GoutteClient;
use Behat\Behat\Tester\Exception\PendingException;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context, SnippetAcceptingContext
{
    private $startUrl = 'http://localhost:8000';
    private $logger;
    private $mink;
      
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct($session, $logger)
    {
        $this->logger=$logger;     
        // init Mink and register sessions
        $this->mink = new Mink(array(
            'goutte1' => new Session(new GoutteDriver(new GoutteClient())),
            'goutte2' => new Session(new GoutteDriver(new GoutteClient())),
            'selenium'  => new Session(new \Behat\Mink\Driver\Selenium2Driver('firefox'))
         ));
        // set the default session name
        $this->mink->setDefaultSessionName('selenium');

        // visit a page
        //$this->mink->getSession()->visit($this->startUrl);
    }
    
    /**
    * @Given the following stores exist:
    */
    public function theFollowingStoresExist(TableNode $table)
    {
        $hash = $table->getHash();
        foreach ($hash as $row) 
        {             
            $this->logger->info($row['name']);
        }
        //throw new PendingException();
    }

    /**
     * @Given I am on :arg1
     */
    public function iAmOn($uri)
    {
        $this->logger->info($uri);
        $this->mink->getSession()->visit($this->startUrl.$uri);
    }

    /**
     * @When I fill :arg1 with :arg2
     */
    public function iFillWith($name, $value)
    {
        //$this->mink->getSession()->getPage()->findLink('Stores')->click();
        $this->mink->getSession()->getPage()->fillField($name, $value);
    }    
    
    /**
     * @When I press :arg1
     */
    public function iPress($arg1)
    {
        $this->mink->getSession()->getPage()->pressButton($arg1);
    }

    /**
     * @Then I should see :arg1
     */
    public function iShouldSee($arg1)
    {
        $notice=$this->mink->getSession()->getPage()->find('named', array('id', 'notice'))->getText();
        PHPUnit_Framework_Assert::assertEquals($arg1, $notice);
    }
}
