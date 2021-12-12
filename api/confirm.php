<?php
  include '../includes/connect.php';
  include '../includes/functions.php';

  if (!empty($_GET['barcode']) && !empty($_GET['id']) && !empty($_GET['param'])) {
   $barcode = filterInput($_GET['barcode']);
   $id = filterInput($_GET['id']);
   $param = filterInput($_GET['param']);
   $stm = $pdo->prepare("DELETE FROM notifications_queue WHERE id = :id");
   $stm->bindValue(':id', $id);
   $stm->execute();
  }
  //127.0.0.1/zalkom/api/confirm.php?barcode=BR-900148190770&id=8&param=1
?>