<?php
  error_reporting(-1);
  ini_set('display_errors', 1);

  echo 'Hello World!<br>';
  
  phpinfo();


  include_once( 'Sample.php');
  $sample->init();

  $sample->set( 'Tom', 56, '1959-04-06');
  $sample->set( 'Joe', 52, '1963-09-23');
  $sample->set( 'Che', 23, '1992-04-19');

  echo '<pre>';
  print_r( $sample->get());
  echo '</pre>';


