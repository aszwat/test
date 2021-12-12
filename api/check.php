<?php
  include '../includes/connect.php';
  include '../includes/functions.php';

  header("Access-Control-Allow-Origin: *");
  header("Access-Control-Allow-Headers: access");
  header("Access-Control-Allow-Methods: GET");
  header("Access-Control-Allow-Credentials: true");
  header('Content-Type: application/json');

  if (!empty($_GET['barcode'])) {
    $barcode=filterInput($_GET['barcode']);
    $stm = $pdo->prepare("SELECT notifications_queue.id, notifications.text FROM notifications_queue INNER JOIN notifications ON notifications.id = notifications_queue.id_notification LEFT JOIN employees ON employees.id = notifications_queue.id_employee WHERE employees.barcode = :barcode");
    $stm->bindValue(':barcode', $barcode);
    $stm->execute();
    $row_check = $stm->fetch();
    //if ($stm->rowCount() > 0) {
      if (($row_check['id'] && $row_check['text']) != '') {
        $id = $row_check['id'];
        $text = $row_check['text'];
      } else {
        $id = 'empty';
        $text = 'empty';
      }
      $output = array(
        "id" => $id,
        "text" => $text
      );
      http_response_code(200);
      echo json_encode($output);
    //}
  } else {
    http_response_code(200);
    echo json_encode($output);
  }
  //127.0.0.1/zalkom/api/check.php?barcode=BR-900148190770
?>