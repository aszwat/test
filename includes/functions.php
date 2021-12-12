<?php
// filter
function filterInput($data) {
  $data = trim($data);
  $data = strip_tags($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

// users
function usersList($role, $group) {
  include 'connect.php';
  if ($role == 'IT') {
    $stm = $pdo->prepare("SELECT * FROM users");
    $stm->execute();
    $data_users = $stm->fetchAll();
    foreach ($data_users as $row_user) {
      $group = subArraysToString(groups('groups_user', $row_user['id'], 'name'));
      $array_users[] = array(
        'id' =>  $row_user['id'],
        'barcode' => $row_user['barcode'],
        'role' => $row_user['role'],
        'group' => $group,
        'comment' => $row_user['comment']
      );
    }
  }
  if ($role == 'AM') {
    $data_groups = $group;
    foreach ($data_groups as $row_group) {
      $group_id = $row_group['id_group'];
      $stm = $pdo->prepare("SELECT users.id, users.barcode, groups.name, users.role, users.comment FROM users INNER JOIN users_groups ON users_groups.id_user = users.id LEFT JOIN groups ON groups.id = users_groups.id_group WHERE groups.id = $group_id");
      $stm->execute();
      $data_users = $stm->fetchAll();
      foreach ($data_users as $row_user) {
        if ($row_user['role'] == 'TL') {
          $group = subArraysToString(groups('groups_user', $row_user['id'], 'name'));
          $array_users[] = array(
            'id' =>  $row_user['id'],
            'barcode' => $row_user['barcode'],
            'group' => $group,
            'comment' => $row_user['comment']
          );
        }
      }
    }
  }
  return sortArray(uniqueArray($array_users, 'barcode'), 'barcode');
}

// groups
function groups($query, $value1, $value2) {
  include 'connect.php';
  if ($query == 'groups') {
    $stm = $pdo->prepare("SELECT id, name FROM groups");
  }
  if ($query == 'groups_user') {
    $stm = $pdo->prepare("SELECT groups.id, groups.name FROM users_groups LEFT JOIN groups ON groups.id = users_groups.id_group WHERE id_user = $value1");
  }
  $stm->execute();
  $data_groups = $stm->fetchAll();
  foreach ($data_groups as $row_group) {
    if ($value2 == 'id') {
      $array_groups[] = array(
        $row_group['id']
      );
    }
    if ($value2 == 'name') {
      $array_groups[] = array(
        'name' => $row_group['name']
      );
    }
    if ($value2 == 'id_name') {
      $array_groups[] = array(
        'id' => $row_group['id'],
        'name' => $row_group['name']
      );
    }
  }
  if ($value2 == 'id') {
    return $array_groups;
  }
  if ($value2 != 'id') {
    return sortArray(uniqueArray($array_groups, 'name'), 'name');
  }
}

// teams
function teamsList($role, $group, $user) {
  include 'connect.php';
  if ($role == 'IT') {
    $stm = $pdo->prepare("SELECT teams.id, teams.name, teams.comment, users.barcode AS owner FROM teams INNER JOIN teams_users ON teams_users.id_team = teams.id LEFT JOIN users ON users.id = teams_users.id_user");
    $stm->execute();
    $data_teams = $stm->fetchAll();
    foreach ($data_teams as $row_team) {
      $owner = subArraysToString(owners('owners_team', $row_team['id'], 'barcode'));
      $array_teams[] = array(
        'id' =>  $row_team['id'],
        'name' => $row_team['name'],
        'owner' => $owner,
        'comment' => $row_team['comment']
      );
    }
  }
  if ($role == 'AM') {
    $data_groups = $group;
    foreach ($data_groups as $row_group) {
      $group_id = $row_group['id_group'];
      $stm = $pdo->prepare("SELECT users_groups.id_user FROM users_groups LEFT JOIN users ON users.id = users_groups.id_user WHERE users_groups.id_group = $group_id");
      $stm->execute();
      $data_owners = $stm->fetchAll();
      foreach ($data_owners as $row_owner) {
        $owner_id = $row_owner['id_user'];
        $stm = $pdo->prepare("SELECT teams.id, teams.name, teams.comment, users.barcode AS owner FROM teams INNER JOIN teams_users ON teams_users.id_team = teams.id LEFT JOIN users ON users.id = teams_users.id_user WHERE teams_users.id_user = $owner_id");
        $stm->execute();
        $data_teams = $stm->fetchAll();
        foreach ($data_teams as $row_team) {
          $owner = subArraysToString(owners('owners_team', $row_team['id'], 'barcode'));
          $array_teams[] = array(
            'id' =>  $row_team['id'],
            'name' => $row_team['name'],
            'owner' => $owner,
            'comment' => $row_team['comment']
          );
        }
      }
    }
  }
  if ($role == 'TL') {
    $owner_id = $user;
    $stm = $pdo->prepare("SELECT teams.id, teams.name, teams.comment FROM teams INNER JOIN teams_users ON teams_users.id_team = teams.id LEFT JOIN users ON users.id = teams_users.id_user WHERE teams_users.id_user = $owner_id");
    $stm->execute();
    $data_teams = $stm->fetchAll();
    foreach ($data_teams as $row_team) {
      $array_teams[] = array(
        'id' =>  $row_team['id'],
        'name' => $row_team['name'],
        'comment' => $row_team['comment']
      );
    }
  }
  return sortArray(uniqueArray($array_teams, 'name'), 'name');
}

// owners
function owners($query, $value1, $value2) {
  include 'connect.php';
  if ($query == 'owners') {
    $stm = $pdo->prepare("SELECT users.id, users.barcode from users");
    $stm->execute();
    $data_owners = $stm->fetchAll();
  }
  if ($query == 'owners_group') {
    $data_groups = $value1;
    foreach ($data_groups as $row_group) {   
      $group_id = $row_group['id_group'];
      $stm = $pdo->prepare("SELECT users.id, users.barcode, users.role FROM users INNER JOIN users_groups ON users_groups.id_user = users.id LEFT JOIN groups ON groups.id = users_groups.id_group WHERE groups.id = $group_id AND users.role = 'TL'");
      $stm->execute();
      $data_groups_owners = $stm->fetchAll();
      foreach ($data_groups_owners as $row_group_owner) {
        $data_owners[] = array(
          'id' =>  $row_group_owner['id'],
          'barcode' => $row_group_owner['barcode']
        );
      }
    }
  }
  if ($query == 'owners_team') {
    $stm = $pdo->prepare("SELECT users.id, users.barcode from teams_users LEFT JOIN users ON users.id = teams_users.id_user WHERE id_team = $value1");
    $stm->execute();
    $data_owners = $stm->fetchAll();
  }
  foreach ($data_owners as $row_owner) {
    if ($value2 == 'id') {
      $array_owners[] = array(
        $row_owner['id']
      );
    }
    if ($value2 == 'barcode') {
      $array_owners[] = array(
        'barcode' => $row_owner['barcode']
      );
    }
    if ($value2 == 'id_barcode') {
      $array_owners[] = array(
        'id' => $row_owner['id'],
        'barcode' => $row_owner['barcode']
      );
    }
  }
  if ($value2 == 'id') {
    return $array_owners;
  }
  if ($value2 != 'id') {
    return sortArray(uniqueArray($array_owners, 'barcode'), 'barcode');
  }
}

// employees
function employeesList($role, $group, $user) {
  include 'connect.php';
  if ($role == 'IT') {
    $stm = $pdo->prepare("SELECT employees.id, employees.barcode, employees.comment, teams.name FROM employees INNER JOIN teams_employees ON teams_employees.id_employee = employees.id LEFT JOIN teams ON teams.id = teams_employees.id_team");
    $stm->execute();
    $data_employees = $stm->fetchAll();
    foreach ($data_employees as $row_employee) {
      $array_employees[] = array(
        'id' =>  $row_employee['id'],
        'barcode' => $row_employee['barcode'],
        'name' => $row_employee['name'],
        'comment' => $row_employee['comment']
      );
    }
  }
  if ($role == 'AM') {
    $data_groups = $group;
    foreach ($data_groups as $row_group) {
      $group_id = $row_group['id_group'];
      $stm = $pdo->prepare("SELECT teams.id FROM teams INNER JOIN teams_users ON teams_users.id_team = teams.id LEFT JOIN users_groups ON users_groups.id_user = teams_users.id_user WHERE users_groups.id_group = $group_id");
      $stm->execute();
      $data_teams = $stm->fetchAll();
      foreach ($data_teams as $row_team) {
        $team_id = $row_team['id'];
        $stm = $pdo->prepare("SELECT employees.id, employees.barcode, employees.comment, teams.name FROM employees INNER JOIN teams_employees ON teams_employees.id_employee = employees.id LEFT JOIN teams ON teams.id = teams_employees.id_team WHERE teams_employees.id_team = $team_id");
        $stm->execute();
        $data_employees = $stm->fetchAll();
        foreach ($data_employees as $row_employee) {
          $array_employees[] = array(
            'id' =>  $row_employee['id'],
            'barcode' => $row_employee['barcode'],
            'name' => $row_employee['name'],
            'comment' => $row_employee['comment']
          );
        }
      }
    }
  }
  if ($role == 'TL') {
    $stm = $pdo->prepare("SELECT employees.id, employees.barcode, employees.comment, teams.name FROM employees INNER JOIN teams_employees ON teams_employees.id_employee = employees.id INNER JOIN teams ON teams.id = teams_employees.id_team LEFT JOIN teams_users ON teams_users.id_team = teams.id WHERE teams_users.id_user = $user");
    $stm->execute();
    $data_employees = $stm->fetchAll();
    foreach ($data_employees as $row_employee) {
      $array_employees[] = array(
        'id' =>  $row_employee['id'],
        'barcode' => $row_employee['barcode'],
        'name' => $row_employee['name'],
        'comment' => $row_employee['comment']
      );
    }

  }
  return sortArray(uniqueArray($array_employees, 'barcode'),'barcode');
}

function teams($query, $value1, $value2) {
  include 'connect.php';
  if ($query == 'teams') {
    $stm = $pdo->prepare("SELECT teams.id, teams.name from teams");
    $stm->execute();
    $data_teams = $stm->fetchAll();
  }
  if ($query == 'teams_group') {
    $data_groups = $value1;
    foreach ($data_groups as $row_group) {   
      $group_id = $row_group['id_group'];
      $stm = $pdo->prepare("SELECT teams.id, teams.name FROM teams INNER JOIN teams_users ON teams_users.id_team = teams.id LEFT JOIN users_groups ON users_groups.id_user = teams_users.id_user WHERE users_groups.id_group = $group_id");
      $stm->execute();
      $data_groups_teams = $stm->fetchAll();
      foreach ($data_groups_teams as $row_group_team) {
        $data_teams[] = array(
          'id' =>  $row_group_team['id'],
          'name' => $row_group_team['name']
        );
      }
    }
  }
  if ($query == 'teams_user') {
     $stm = $pdo->prepare("SELECT teams.id, teams.name, teams.comment FROM teams INNER JOIN teams_users ON teams_users.id_team = teams.id LEFT JOIN users_groups ON users_groups.id_user = teams_users.id_user WHERE users_groups.id_user = $value1");
    $stm->execute();
    $data_teams = $stm->fetchAll();
  }
  foreach ($data_teams as $row_team) {
    if ($value2 == 'id') {
      $array_teams[] = array(
        $row_team['id']
      );
    }
    if ($value2 == 'name') {
      $array_teams[] = array(
        'barcode' => $row_team['name']
      );
    }
    if ($value2 == 'id_name') {
      $array_teams[] = array(
        'id' => $row_team['id'],
        'name' => $row_team['name']
      );
    }
  }
  if ($value2 == 'id') {
    return $array_teams;
  }
  if ($value2 != 'id') {
    return sortArray(uniqueArray($array_teams, 'name'), 'name');
  }
}

function employees($query, $value1, $value2) {
  include 'connect.php';
  if ($query == 'employees') {
    $stm = $pdo->prepare("SELECT id, barcode from employees");
    $stm->execute();
    $data_employees = $stm->fetchAll();
  }
  if ($query == 'employees_group') {
    $data_groups = $value1;
    foreach ($data_groups as $row_group) {
      $group_id = $row_group['id_group'];
      $stm = $pdo->prepare("SELECT teams.id FROM teams INNER JOIN teams_users ON teams_users.id_team = teams.id LEFT JOIN users_groups ON users_groups.id_user = teams_users.id_user WHERE users_groups.id_group = $group_id");
      $stm->execute();
      $data_teams = $stm->fetchAll();
      foreach ($data_teams as $row_team) {
        $team_id = $row_team['id'];
        $stm = $pdo->prepare("SELECT employees.id, employees.barcode FROM employees INNER JOIN teams_employees ON teams_employees.id_employee = employees.id LEFT JOIN teams ON teams.id = teams_employees.id_team WHERE teams_employees.id_team = $team_id");
        $stm->execute();
        $data_employees = $stm->fetchAll();
        foreach ($data_employees as $row_employee) {
          $array_employees[] = array(
            'id' =>  $row_employee['id'],
            'barcode' => $row_employee['barcode']
          );
        }
      }
    }
  }
  if ($query == 'employees_user') {
     $stm = $pdo->prepare("SELECT employees.id, employees.barcode FROM employees INNER JOIN teams_employees ON teams_employees.id_employee = employees.id INNER JOIN teams ON teams.id = teams_employees.id_team LEFT JOIN teams_users ON teams_users.id_team = teams.id WHERE teams_users.id_user = $value1");
    $stm->execute();
    $data_employees = $stm->fetchAll();
  }
  foreach ($data_employees as $row_employee) {
    if ($value2 == 'id') {
      $array_employees[] = array(
        $row_employee['id']
      );
    }
    if ($value2 == 'barcode') {
      $array_employees[] = array(
        'barcode' => $row_employee['barcode']
      );
    }
    if ($value2 == 'id_barcode') {
      $array_employees[] = array(
        'id' => $row_employee['id'],
        'barcode' => $row_employee['barcode']
      );
    }
  }
  if ($value2 == 'id') {
    return $array_employees;
  }
  if ($value2 != 'id') {
    return sortArray(uniqueArray($array_employees, 'barcode'), 'barcode');
  }
}

// notifications
function notificationsList($role, $group, $user) {
  include 'connect.php';
  if ($role == 'IT') {
    $stm = $pdo->prepare("SELECT id, recipient_type, state FROM notifications_send");
    $stm->execute();
    $data_send_notifications = $stm->fetchAll();
    foreach ($data_send_notifications as $row_send_notification) {
      $id = $row_send_notification['id'];
      $recipient_type = $row_send_notification['recipient_type'];
      $state = $row_send_notification['state'];
      if ($row_send_notification['recipient_type'] == 1) {
        $stm = $pdo->prepare("SELECT notifications_send.id, notifications_send.date, notifications.text, teams.name FROM notifications_send INNER JOIN notifications ON notifications.id = notifications_send.id_notification LEFT JOIN teams ON teams.id = notifications_send.id_recipient WHERE notifications_send.id = $id");
      }
      if ($row_send_notification['recipient_type'] == 2) {
        $stm = $pdo->prepare("SELECT notifications_send.id, notifications_send.date, notifications.text, employees.barcode FROM notifications_send INNER JOIN notifications ON notifications.id = notifications_send.id_notification LEFT JOIN employees ON employees.id = notifications_send.id_recipient WHERE notifications_send.id = $id");
      }
      $stm->execute();
      $send_notification = $stm->fetch();
      $date = $send_notification['date'];
      if ($recipient_type == 1) {
        $recipient = $send_notification['name'];
      }
      if ($recipient_type == 2) {
        $recipient = $send_notification['barcode'];
      }
      $text = $send_notification['text'];
      $array_notifications[] = array(
        'id' => $id,
        'date' => $date,
        'recipient' => $recipient,
        'text' => $text,
        'state' => $state
      );
    }
  }
  if ($role == 'AM') {
    $data_groups = $group;
    foreach ($data_groups as $row_group) {
      $group_id = $row_group['id_group'];
      $stm = $pdo->prepare("SELECT id_user FROM users_groups WHERE id_group = $group_id");
      $stm->execute();
      $data_users = $stm->fetchAll();
      foreach ($data_users as $row_user) {
        $user = $row_user['id_user'];
        $stm = $pdo->prepare("SELECT id, recipient_type, state FROM notifications_send WHERE id_user = $user");
        $stm->execute();
        $data_send_notifications = $stm->fetchAll();
        foreach ($data_send_notifications as $row_send_notification) {
          $id = $row_send_notification['id'];
          $recipient_type = $row_send_notification['recipient_type'];
          $state = $row_send_notification['state'];
          if ($row_send_notification['recipient_type'] == 1) {
            $stm = $pdo->prepare("SELECT notifications_send.id, notifications_send.date, notifications.text, teams.name FROM notifications_send INNER JOIN notifications ON notifications.id = notifications_send.id_notification LEFT JOIN teams ON teams.id = notifications_send.id_recipient WHERE notifications_send.id = $id");
          }
          if ($row_send_notification['recipient_type'] == 2) {
            $stm = $pdo->prepare("SELECT notifications_send.id, notifications_send.date, notifications.text, employees.barcode FROM notifications_send INNER JOIN notifications ON notifications.id = notifications_send.id_notification LEFT JOIN employees ON employees.id = notifications_send.id_recipient WHERE notifications_send.id = $id");
          }
          $stm->execute();
          $send_notification = $stm->fetch();
          $date = $send_notification['date'];
          if ($recipient_type == 1) {
            $recipient = $send_notification['name'];
          }
          if ($recipient_type == 2) {
            $recipient = $send_notification['barcode'];
          }
          $text = $send_notification['text'];
          if ($state == '1') {
            $array_notifications[] = array(
              'id' => $id,
              'date' => $date,
              'recipient' => $recipient,
              'text' => $text,
              'state' => $state
            );
          }
        }
      }
    }
  }
  if ($role == 'TL') {
    $stm = $pdo->prepare("SELECT id, recipient_type, state FROM notifications_send WHERE id_user = $user");
    $stm->execute();
    $data_send_notifications = $stm->fetchAll();
    foreach ($data_send_notifications as $row_send_notification) {
      $id = $row_send_notification['id'];
      $recipient_type = $row_send_notification['recipient_type'];
      $state = $row_send_notification['state'];
      if ($row_send_notification['recipient_type'] == 1) {
        $stm = $pdo->prepare("SELECT notifications_send.id, notifications_send.date, notifications.text, teams.name FROM notifications_send INNER JOIN notifications ON notifications.id = notifications_send.id_notification LEFT JOIN teams ON teams.id = notifications_send.id_recipient WHERE notifications_send.id = $id");
      }
      if ($row_send_notification['recipient_type'] == 2) {
        $stm = $pdo->prepare("SELECT notifications_send.id, notifications_send.date, notifications.text, employees.barcode FROM notifications_send INNER JOIN notifications ON notifications.id = notifications_send.id_notification LEFT JOIN employees ON employees.id = notifications_send.id_recipient WHERE notifications_send.id = $id");
      }
      $stm->execute();
      $send_notification = $stm->fetch();
      $date = $send_notification['date'];
      if ($recipient_type == 1) {
        $recipient = $send_notification['name'];
      }
      if ($recipient_type == 2) {
        $recipient = $send_notification['barcode'];
      }
      $text = $send_notification['text'];
      if ($state == '1') {
        $array_notifications[] = array(
          'id' => $id,
          'date' => $date,
          'recipient' => $recipient,
          'text' => $text,
          'state' => $state
        );
      }
    }
  }
  return sortArray($array_notifications, 'date');
}

// arr to str
function subArraysToString($array, $separator = '<br>') {
  $string = '';
  foreach ($array as $value) {
    $string .= implode($separator, $value);
    $string .= $separator;
  }
  $string = rtrim($string, $separator);
  return $string;
}

// arr uniq
function uniqueArray($array, $keyname) {
  $array_unique = array();
  foreach ($array as $key => $value) {
    if (!isset($array_unique[$value[$keyname]])) {
      $array_unique[$value[$keyname]] = $value;
    }
  }
  $array_unique = array_values($array_unique);
  return $array_unique;
}

// arr sort
function sortArray($array, $keyname) {
  $keys = array_column($array, $keyname);
  array_multisort($keys, SORT_ASC, $array);
  return $array;
}

// add event
function addEvent($type, $user, $message) {
  include 'connect.php';
  $ip = filter_input(INPUT_SERVER, 'REMOTE_ADDR', FILTER_SANITIZE_STRING);
  if (!empty(filter_input(INPUT_SERVER, 'HTTP_CLIENT_IP', FILTER_SANITIZE_STRING))) {
    $ip = filter_input(INPUT_SERVER, 'HTTP_CLIENT_IP', FILTER_SANITIZE_STRING);
  }
  if (!empty(filter_input(INPUT_SERVER, 'HTTP_X_FORWARDED_FOR', FILTER_SANITIZE_STRING))) {
    $ip = filter_input(INPUT_SERVER, 'HTTP_X_FORWARDED_FOR', FILTER_SANITIZE_STRING);
  }
  $date = date('Y-m-d H:i:s');
  $stm = $pdo->prepare("SELECT COUNT(*) FROM events");
  $stm->execute();
  $count = $stm->fetchColumn();
  if ($count < 1000) {
    $stm = $pdo->prepare("INSERT INTO events (type, date, user, ip, message) VALUES (:type, :date, :user, :ip, :message)");
    $stm->bindValue(':type', $type);
    $stm->bindValue(':date', $date);
    $stm->bindValue(':user', $user);
    $stm->bindValue(':ip', $ip);
    $stm->bindValue(':message', $message);
    $stm->execute();
    $number = $pdo->lastInsertId();
  }
  if ($count >= 1000) {
    $stm = $pdo->prepare("SELECT number FROM counter");
    $stm->execute();
    $row = $stm->fetch();
    $number = $row['number'];
    if ($number == 1000) {
      $number = 1;
    }
    $stm = $pdo->prepare("UPDATE events SET type = :type, date = :date, user = :user, ip = :ip, message = :message WHERE id = $number");
    $stm->bindValue(':type', $type);
    $stm->bindValue(':date', $date);
    $stm->bindValue(':user', $user);
    $stm->bindValue(':ip', $ip);
    $stm->bindValue(':message', $message);
    $stm->execute();
    $number++;
  }
  $stm = $pdo->prepare("TRUNCATE TABLE `counter`");
  $stm->execute();
  $stm = $pdo->prepare("INSERT INTO counter (number) VALUES ($number)");
  $stm->execute();
}
?>