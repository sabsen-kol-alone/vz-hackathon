<?php 

class Sample {

  public function __construct() {
  }

  public function set( $value) {
    $fp = fopen( __DIR__ . '/sample.txt', "w");
    fputs( $fp, $value."\n");
    fclose( $fp);
    return true;
  }

  public function get() {
    $fp = fopen( __DIR__ . '/sample.txt', "r");
    $value = fgets( $fp);
    fclose( $fp);
    return $value;
  }
}
