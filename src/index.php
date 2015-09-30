<?php
  error_reporting(-1);
  ini_set('display_errors', 1);

  echo '
    <html>
    <head><title>Sample Page</title></head>
    <body>';

  echo '<h1>Sample Page Headline</h1>';
  
//  phpinfo();

  include_once( 'Sample.php');

  $sample = new Sample();
  $sample->init();

  $sample->set( 'Tom', 10);
  $sample->set( 'Joe', 20);
  $sample->set( 'Che', 30);

  $names = $sample->get_name(10);
  echo "<p>ID: {$names[0]['id']} Name: {$names[0]['name']}</p>";

  $names = $sample->get_name(30);
  echo "<p>ID: {$names[0]['id']} Name: {$names[0]['name']}</p>";

  $ids = $sample->get_id('Joe');
  echo "<p>ID: {$ids[0]['id']} Name: {$ids[0]['name']}</p>";

  echo '</body></html>';
