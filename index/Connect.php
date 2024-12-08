<?php
class Connect extends PDO
{
  public function __construct()
  {
    require_once __DIR__ . '/config.php';
    parent::__construct(
      "mysql:host=$dbhost;dbname=$dbname",
      $dbuser,
      $dbpass,
      array(
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        PDO::ATTR_EMULATE_PREPARES => false,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
      )
    );
  }
}
