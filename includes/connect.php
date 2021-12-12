<?php
  include 'config.php';
  $dsn = "mysql:host=$mysql_server_name;dbname=$mysql_db_name;charset=$charset";
  $options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
  ];
  try {
    $pdo = new PDO($dsn, $mysql_user_name, $mysql_user_pass, $options);
  } catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
  }
?>