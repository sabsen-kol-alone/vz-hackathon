<?php

  use Drupal\DrupalExtension\Context\RawDrupalContext;
  use Behat\Behat\Context\SnippetAcceptingContext;
  use Behat\Gherkin\Node\PyStringNode;
  use Behat\Gherkin\Node\TableNode;
  use Behat\Behat\Event\StepEvent;
  use Behat\Behat\Hook\Scope\AfterStepScope;

// use Behat\Behat\Context\Context;
// use Behat\Behat\Context\SnippetAcceptingContext;
// use Behat\Gherkin\Node\PyStringNode;
// use Behat\Gherkin\Node\TableNode;

include __DIR__ . "/../../../src/Sample.php";
/**
 * Defines application features from the specific context.
 */
// class MyContext implements Context, SnippetAcceptingContext
class MyContext extends RawDrupalContext 
                    implements SnippetAcceptingContext
{
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
    }

    /**
     * @Given I set a value :arg1
     */
    public function iSetAValue($arg1)
    {
      $data = new Sample();
      if( $data->set( $arg1)) {
        return true;
      } else {
        throw new Exception( "Could not set value.\n");
      }
    }

    /**
     * @Then I should get back :arg1
     */
    public function iShouldGetBack($arg1)
    {
      $data = new Sample();
      $val = trim($data->get());
      if( $val != $arg1) {
        throw new Exception( "Value did not match.\n");
      }
    }

}
