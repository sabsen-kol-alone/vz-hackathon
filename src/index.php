<?php
  error_reporting(-1);
  ini_set('display_errors', 1);

  echo 'Hello World!<br>';
  
  $hasMySQL = false;
  $hasMySQLi = false;
  $withMySQLnd = false;
  $sentence = '';

  if (function_exists('mysql_connect')) {
    $hasMySQL = true;
    $sentence.= "(Deprecated) MySQL <b>is installed</b>.<br>";
  } else 
    $sentence.= "(Deprecated) MySQL <b>is not installed</b>.<br>";

  if (function_exists('mysqli_connect')) {
    $hasMySQLi = true;
    $sentence.= "and the new (improved) MySQL <b>is installed</b>.<br>";
  } else
    $sentence.= "and the new (improved) MySQL <b>is not installed</b>.<br>";

  if (function_exists('mysqli_get_client_stats')) {
    $withMySQLnd = true;
    $sentence.= "This server is using MySQLnd as the driver.<br>";
  } else
    $sentence.= "This server is using libmysqlclient as the driver.<br>";

  echo $sentence;

/*  
  phpinfo();

  include_once( 'Sample.php');
  $sample->init();

  $sample->set( 'Tom', 56, '1959-04-06');
  $sample->set( 'Joe', 52, '1963-09-23');
  $sample->set( 'Che', 23, '1992-04-19');

  echo '<pre>';
  print_r( $sample->get());
  echo '</pre>';
*/

