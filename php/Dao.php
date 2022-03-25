<?php
// Dao.php
require_once 'KLogger.php';
class Dao {

  private $logger = null;

  private $host = "us-cdbr-east-05.cleardb.net";
  private $db = "heroku_0738745b186c3ed";
  private $user = "be29f0f1e85bb0";
  private $pass = "89021a0f";

  public function __construct() {
    $this->logger = new KLogger ( "log.txt" , KLogger::WARN );
  }
  public function getConnection () {
    $this->logger->LogDebug("getting a connection...");
    try {
      return
        new PDO("mysql:host={$this->host};dbname={$this->db}", $this->user, $this->pass);
    } catch (Exception $e) {
       $this->logger->LogFatal("The database exploded " . print_r($e,1));
       exit;
    }
  }
  public function deleteComment ($id) {
     $this->logger->LogInfo("comment deleted, id=[{$id}]");
    
    $conn = $this->getConnection();
    $deleteQuery = "DELETE FROM comment WHERE comment_id = :id";
    $q = $conn->prepare($deleteQuery);
    $q->bindParam(":id", $id);
    $q->execute();
  }

  public function saveComment ($comment, $image_location) {
    $conn = $this->getConnection();
    $saveQuery =
        "INSERT INTO comment
        (comment, image)
        VALUES
        (:comment, :image)";
    $q = $conn->prepare($saveQuery);
    $q->bindParam(":comment", $comment);
    $q->bindParam(":image", $image_location);
    $q->execute();
  }

  public function getComments () {
    $conn = $this->getConnection();
    return $conn->query("SELECT * FROM comment ORDER BY date_entered DESC");
  }
}