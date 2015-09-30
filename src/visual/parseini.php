<?php

/**
 * Parse behat.ini
 */

  $ini_file = "behat.ini";
  $env = getenv( "ENV");

  if(( $ini = parse_ini_file( $ini_file, true )) === false ) {
    echo "Couldn't find behat.ini in Behat app folder.\n";
    exit(1);
  }

  $timezone    = @$ini[$env]['timezone'];
  $web_url     = @$ini[$env]['behat_web_url'];

  $app = 'verizon';

  $timezone = 'Asia/Calcutta';
  date_default_timezone_set( $timezone);

  $test_path   = __DIR__ . '/../' . @$ini[$app]['test_path'];
