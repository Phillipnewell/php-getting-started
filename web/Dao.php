<?php
// Dao.php
// class for getting products in MySQL
class Dao {

  private $host = "us-cdbr-east-05.cleardb.net";
  private $db = "heroku_0738745b186c3ed";
  private $user = "be29f0f1e85bb0";
  private $pass = "89021a0f";

  public function getConnection () {
    return
      new PDO("mysql:host={$this->host};dbname={$this->db}", $this->user,
          $this->pass);
  }