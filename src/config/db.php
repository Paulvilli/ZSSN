<?php
  class db{
    private $dbHost ='localhost';
    private $dbUser = 'Your user';
    private $dbPass = 'Your pass';
    private $dbName = 'ZSSN';
    //conección 
    public function conectDB(){
      $mysqlConnect = "mysql:host=$this->dbHost;dbname=$this->dbName";
      $dbConnecion = new PDO($mysqlConnect, $this->dbUser, $this->dbPass);
      $dbConnecion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      return $dbConnecion;
    }
  }
