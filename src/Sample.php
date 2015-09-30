<?php 

class Sample {

  private $debug = false;
  private $db = null;
  
  public function __construct() {

    $env = getenv('ENV');
    $this->msg( "Environment: {$env}\n" );

    $hostname = 'localhost';
    $username = 'test';
    $password = 'test';
    $database = 'test';
    
    if( $env == 'pivotal') {
      $hostname = 'us-cdbr-iron-east-03.cleardb.net';
      $username = 'be0b9be2215cc9';
      $password = '8fb87be6';
      $database = 'ad_8c7dc9fcb083716';

    } else if( $env == 'travis') {
      $hostname = '127.0.0.1:3306';
      $username = 'root';
      $password = '';
      $database = 'test';
    }

    try {
      $this->db = new PDO( 
                   "mysql:host={$hostname};dbname={$database}", 
                   $username, 
                   $password);

      $this->msg( "Connected to database ...");
    }
    catch(PDOException $e) {
      $this->msg( "Couldn't connect to database ...", "error");
      $this->msg( $e->getMessage(), "error");
      exit(1);
    }
  }

  public function set( $name, $id) {
    $data = array( $name, $id);
    return $this->set_array( $data);
  }

  private function set_array( $data) {
    try {
      $this->db->beginTransaction();
      
      $query = 
        "INSERT INTO sample ( name, id) VALUES ( ?, ?)";
      
      $prep = $this->db->prepare($query);
      $prep->execute($data);

      $this->db->commit();
      return true;
      
    } catch(PDOException $e) {
      $this->db->rollBack();
      $this->msg( $e->getMessage(), "error");
      return false;
    }
  }

  public function get_name($id) {
    
    $data = array();
    $query = "SELECT * from sample where id = ?";
    $data = array( $id);

    $this->msg( "Fetching all data ...\n");

    try {

      $prep = $this->db->prepare($query);
      $prep->execute( $data);
      $rows = $prep->fetchAll();
      return $rows;

    } catch(PDOException $e) {

      echo $e->getMessage();
      $this->msg( $e->getMessage(), "error");
      exit(1);
    }
    
/***
    echo "Fetching one row at a time ...\n";
    $prep = $this->db->prepare($query);
    $prep->execute( $data);
    while( $row = $prep->fetch()) {
      print_r($row);
    }
***/
  }

  public function get_id($name) {
    
    $data = array();
    $query = "SELECT * from sample where name = ?";
    $data = array( $name);

    $this->msg( "Fetching all data ...\n");

    try {

      $prep = $this->db->prepare($query);
      $prep->execute( $data);
      $rows = $prep->fetchAll();
      return $rows;

    } catch(PDOException $e) {

      echo $e->getMessage();
      $this->msg( $e->getMessage(), "error");
      exit(1);
    }
  }

  private function truncate( $table) {
    try {
      $this->db->beginTransaction();

      $query = "TRUNCATE TABLE ?";

      $prep = $this->db->prepare($query);
      $prep->execute(array( $table));

      $this->db->commit();
      return true;

    } catch(PDOException $e) {
      $this->db->rollBack();
      $this->msg( $e->getMessage(), "error");
      return false;
    }
  }

  private function msg( $msg, $type = "") {
    if( $this->debug || $type == 'error') {
      echo $msg . "\n";
    }
  }

  public function init() {

    try {
      $this->db->beginTransaction();
      
      $prep = $this->db->prepare( "DROP TABLE IF EXISTS sample" );
      $prep->execute();
      $this->msg( "Table dropped ...");

      $table_def = 
        "CREATE TABLE IF NOT EXISTS sample (
         name          varchar(30) NOT NULL,
         id            int(10) NOT NULL,
         PRIMARY KEY   (id)
      ) ENGINE=InnoDB DEFAULT CHARSET=latin1";
      
      $prep = $this->db->prepare($table_def);
      $prep->execute();
      $this->msg( "Table created ...");

      $this->db->commit();
      
    } catch(PDOException $e) {
      $db->rollBack();
      $this->msg( $e->getMessage(), "error");
      exit(1);
    }
  }
}
