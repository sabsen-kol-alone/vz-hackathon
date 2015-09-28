<?php 

class Sample {

  private $debug = true;
  private $db = null;
  
  public function __construct() {

    $env = getenv('ENV');

    if( $env == 'pivotal') {
      $hostname = 'us-cdbr-iron-east-03.cleardb.net';
      $username = 'b41a04c42e55e3';
      $password = '8d96c73c';
      $database = 'ad_1bc8e31313604ae';

    } else if( $env == 'travis') {
      $hostname = '127.0.0.1';
      $username = 'root';
      $password = '';
      $database = 'test';

    } else if( $env == 'local') {

      $hostname = '127.0.0.1';
      $username = 'root';
      $password = 'Sonai!2306';
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

  public function set( $name, $age, $date_of_birth) {
    $data = array( $name, $age, $date_of_birth);
    return $this->set_array( $data);
  }

  private function set_array( $data) {
    try {
      $this->db->beginTransaction();
      
      $query = 
        "INSERT INTO sample ( id, name, age, date_of_birth) 
           VALUES ( NULL, ?, ?, ?)";
      
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

  public function get($id = null) {
    
    $data = array();
    if( $id === null ) {
      $query = "SELECT * from sample";
    } else {
      $query = "SELECT * from sample where id = ?";
      $data = array( $id);
    }

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
         id            int(10) unsigned NOT NULL AUTO_INCREMENT,
         name          varchar(30) NOT NULL,
         age           tinyint(4) NOT NULL,
         date_of_birth date NOT NULL,
         PRIMARY KEY   (id)
      ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
      
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

  $sample = new Sample();
//  $sample->init();
  
//  $sample->set( 'saby', 56, '1959-10-06');
//  $sample->set( 'piu', 52, '1963-07-23');
//  $sample->set( 'sonai', 23, '1992-02-19');

//  print_r( $sample->get());
