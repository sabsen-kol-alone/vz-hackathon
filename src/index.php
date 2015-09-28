<?php
  error_reporting(-1);
  ini_set('display_errors', 1);

  echo 'Hello World!<br>';
  
//  phpinfo();

  include_once( 'Sample.php');

  $sample = new Sample();
  $sample->init();

  $sample->set( 'Tom', 10);
  $sample->set( 'Joe', 20);
  $sample->set( 'Che', 30);

  echo '<pre>';
  print_r( $sample->get_name(10));
  print_r( $sample->get_name(30));
  print_r( $sample->get_id('Joe'));
  echo '</pre>';
