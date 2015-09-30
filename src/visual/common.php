<?php

/**
 * function   : url_exists
 * Checks whether a URL is accessible
 */
function url_exists( $url) {
  $headers = @get_headers($url);
//  print_r( $headers);
  if( is_array( $headers)) {
    foreach( $headers as $hdr) {
      if( strpos( $hdr, "200 OK") !== false ) {
        return true;
      }
    }
  }
  return false;
}

/**
 * function   : recursive_file_list
 * Recursively gets all the files and folders from a given folder
 */
function recursive_file_list($base_dir, $extension = null) {
  $list = array();

  $scan_result = @scandir($base_dir);

  if( $scan_result) { 
    foreach(scandir($base_dir) as $file) {

      if($file == '.' || $file == '..') continue;

      $dir = $base_dir.'/'.$file;
      

      if( $extension != null ) {
        $ext = substr( $dir, (-1*(strlen($extension)+1))); 
        if( is_dir($dir)) {
          $l = recursive_file_list($dir, $extension);
          if( $l) {
            $list = array_merge($list, $l);
          }
        } else if( $ext != ".{$extension}" ) {
          
//          echo $dir . " | " . ".{$extension}" . " | " . $ext . "<br>";
          continue;
        } else {
          $list[] = $dir;
        }

      } else 
      if(is_dir($dir)) {
        $l = recursive_file_list($dir);
        if( $l) {
          $list = array_merge($list, $l);
        }

      } else {
        $list[]= $dir;
      }
    }
  }

  return $list;
}

/**
 * Recursively delete files and folders from a directory.
 * Including the directory itself.
 */
function recursive_remove( $dir ) { 
   if (is_dir($dir)) { 
     $objects = scandir($dir); 
     foreach ($objects as $object) { 
       if ($object != "." && $object != "..") { 
         if (filetype($dir."/".$object) == "dir") 
           recursive_remove($dir."/".$object); 
         else 
           unlink($dir."/".$object); 
       } 
     } 
     reset($objects); 
     rmdir($dir); 
   } 
 }

/**
 * Generate a random string of $length characters
 */
function random_string($length) {
    $key = '';
    $keys = array_merge(range(0, 9), range('a', 'z'));

    for ($i = 0; $i < $length; $i++) {
        $key .= $keys[array_rand($keys)];
    }

    return $key;
}


