<?php

  declare(strict_types = 1);

  function getDatabaseConnection() : PDO {
    $db = new PDO('sqlite:' . __DIR__ . '/database.db');
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (NULL == $db) 
    throw new Exception("Failed to open database");

    return $db;
  }

/*
  class Database {
    private static $instance = NULL;
    private $db = NULL;
    
    private function __construct() {
      $db = new PDO('sqlite: database/database.db');
      $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
      $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      /*
      $this->db->query('PRAGMA foreign_keys = ON');
      if (NULL == $this->db) 
        throw new Exception("Failed to open database");

    }


    public function db() {
      return $this->db;
    }

    static function instance() {
      if (NULL == self::$instance) {
        self::$instance = new Database();
      }
      return self::$instance;
    }
  }
*/

?>