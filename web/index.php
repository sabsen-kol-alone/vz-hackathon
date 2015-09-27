<?php
  include_once( __DIR__ . '/../src/Sample.php');

  echo 'Hello World!<br>';
  
  phpinfo();

  $sample->init();

  $sample->set( 'Tom', 56, '1959-04-06');
  $sample->set( 'Joe', 52, '1963-09-23');
  $sample->set( 'Che', 23, '1992-04-19');

  echo '<pre>';
  print_r( $sample->get());
  echo '</pre>';


