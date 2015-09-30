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

include __DIR__ . "/../../../Sample.php";

/**
 * Defines application features from the specific context.
 */
// class MyContext implements Context, SnippetAcceptingContext
class MyContext extends RawDrupalContext 
                    implements SnippetAcceptingContext {
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
   * @Given the following people exist:
  */
  public function theFollowingPeopleExist(TableNode $table) {
    $data = new Sample();
    $values = $table->getColumnsHash();
    foreach( $values as $val ) {
      $data->set( $val['name'], $val['id']);
    }
  }
  
  /**
   * @Then id of name :arg1 should be :arg2
   */
    public function idOfNameShouldBe($arg1, $arg2) {
    $data = new Sample();
    $rows = $data->get_id( $arg1);
   //     print_r( $rows);
    if( sizeof( $rows) != 1 ) {
      throw new Exception( "ID is not present.\n");
    } else
    if( $rows[0]['id'] != $arg2 ) {
      throw new Exception( "ID did not match.\n");
    }
  }
  
  /**
   * @Then name of id :arg1 should be :arg2
   */
  public function nameOfIdShouldBe($arg1, $arg2)
  {
    $data = new Sample();
    $rows = $data->get_name( $arg1);
  //      print_r( $rows);
    if( sizeof( $rows) != 1 ) {
      throw new Exception( "Name is not present.\n");
    } else
    if( $rows[0]['name'] != $arg2 ) {
      throw new Exception( "Name did not match.\n");
    }
  }
}
