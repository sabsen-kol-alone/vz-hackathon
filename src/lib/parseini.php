<?php

/**
 * Parse behat.ini
 */

  $ini_file = __DIR__ . "/../behat.ini";

/**
 *  Uncomment this section when you want to test
 *  the mailing functionalilty
 *

    mail_host = "smtp.verizon.com"

    smtp_auth = false

    from_email = "sabyasachi.x.sengupta@one.verizon.com"
    from_name = "Sabyasachi Sengupta"

    to_email[] = "sabyasachi.x.sengupta@one.verizon.com"
    to_name[] = "Sabyasachi Sengupta"

    reply_to_email[] = "sabyasachi.x.sengupta@one.verizon.com"
    reply_to_name[] = "Sabyasachi Sengupta"

    subject = "Behat log as of {date}"

    body = "Please find the attached log files."

 */

  if( !empty($_GET['a'])) {
    $app = $_GET['a'];
  } else if( !empty($_POST['application'])) {
    $app = $_POST['application'];
  } else if( empty( $app)) {
    $app = 'all';
  }

  if(( $ini = parse_ini_file( $ini_file, true )) === false ) {
    echo "Couldn't find behat.ini in Behat app folder.\n";
    exit(1);
  }

  $environment = $ini['behat']['environment'];
  $interface   = $ini['behat']['interface'];

  $system_tmp  = @$ini[$environment]['system_tmp'];
  $behat_home  = @$ini[$environment]['behat_home'];
  $php_bin     = @$ini[$environment]['php_bin'];
  $java_bin    = @$ini[$environment]['java_bin'];
  $behat_bin   = @$ini[$environment]['behat_bin'];
  $browser_bin = @$ini[$environment]['browser_bin'];
  $timezone    = @$ini[$environment]['timezone'];
  $web_url     = @$ini[$environment]['behat_web_url'];

  if( empty($behat_home) || empty( $php_bin)
      || empty( $behat_bin) || empty( $browser_bin)
      || empty( $java_bin) || empty( $timezone)) {

    echo "[behat] section attributes are not properly defined in behat.ini.\n";
    echo "Possible reasons:\n";
    echo "   1) [behat] section is missing.\n";
    echo "   2) 'behat_home' attribute is missing.\n";
    echo "   3) 'php_bin' attribute is missing.\n";
    echo "   4) 'behat_bin' attribute is missing.\n";
    echo "   5) 'browser_bin' attribute is missing.\n";
    exit(1);
  }

/**
 * Set timezone
 */

  date_default_timezone_set( $timezone);

  $apps = array();
  foreach( $ini as $key => $val ) {
      
    if( in_array( $key, 
          array('behat','server','local','project_name' ))) {
      continue;
    }
    $apps[] = $key;
    $test_paths[$key] =  @$val['test_path'];
  }

//  echo "[".$app."]<br>";
  if( $app != 'all' ) {
    $test_path   = @$ini[$app]['test_path'];
    $log_path    = $test_path . '/output';
    $behat_parms = @$ini[$app]['behat_parms'];
    $html_file   = 'report.html';

    if( empty( $test_path)) {
      echo "Application {$app} not defined in C:/behat/behat.ini.\n";
      echo "Possible reasons:\n";
      echo "   1) [{$app}] section is missing.\n";
      echo "   2) 'test_path' attribute is missing.\n";
      echo "Copy the [project_name] sample section to create your own.\n";
      exit(1);
    }
  }

/** Not needed at present
  $from_email        = @$ini[$app]['from_email'];
  $from_name         = @$ini[$app]['from_name'];

  $to_email          = @$ini[$app]['to_email']; // array
  $to_name           = @$ini[$app]['to_name']; // array

  $reply_to_email    = @$ini[$app]['reply_to_email']; // array
  $reply_to_name     = @$ini[$app]['reply_to_name']; // array

  $subject           = @$ini[$app]['subject']; // Replace {date} with current date
  $body              = @$ini[$app]['body'];

  $mail_host         = @$ini[$app]['mail_host'];
  $smtp_auth         = @$ini[$app]['smtp_auth'];
  $from_email        = @$ini[$app]['from_email'];
  $from_name         = @$ini[$app]['from_name'];

  $to_email          = @$ini[$app]['to_email']; // array
  $to_name           = @$ini[$app]['to_name']; // array

  $reply_to_email    = @$ini[$app]['reply_to_email']; // array
  $reply_to_name     = @$ini[$app]['reply_to_name']; // array

  $subject           = @$ini[$app]['subject']; // Replace {date} with current date
  $body              = @$ini[$app]['body'];

  $mail_host         = @$ini[$app]['mail_host'];
  $smtp_auth         = @$ini[$app]['smtp_auth'];

 */
