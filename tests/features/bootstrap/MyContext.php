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
      $data = new Sample();
      $data->init();
    }

    /**
     * @Given I set values :arg1, :arg2, :arg3
     */
    public function iSetAValue($arg1, $arg2, $arg3)
    {
      $data = new Sample();
      if( $data->set( $arg1, $arg2, $arg3)) {
        return true;
      } else {
        throw new Exception( "Could not set values.\n");
      }
    }

    /**
     * @Then id :arg1 should get back :arg2, :arg3, :arg4
     */
    public function iShouldGetBack($arg1, $arg2, $arg3, $arg4)
    {
      $data = new Sample();
      $rows = $data->get( $arg1);
      print_r( $rows);
      $row = $rows[0];
      if( $row[1] != $arg2 || $row[2] != $arg3 || $row[3] != $arg4 ) {
        throw new Exception( "Some Values did not match.\n");
      }
    }

}
