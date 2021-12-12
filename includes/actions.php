<?php
// check session existence
if (!isset($_SESSION)) session_start();

// required files
include 'connect.php';
include 'functions.php';

// login form
if (isset($_POST['action_login'])) {
  if ($_POST['action_login'] == 'login') {
    $user = filterInput($_POST['user']);
    $stm = $pdo->prepare("SELECT * FROM users WHERE barcode = :barcode");
    $stm->bindValue('barcode', $user);
    $stm->execute();
    $user_count = $stm->fetchColumn();
    if ($user_count > 0) {
      $stm->execute();
      $row_user = $stm->fetch();
      $_SESSION['logged'] = true;
      $_SESSION['user_id'] = $row_user['id'];
      $_SESSION['user_barcode'] = $row_user['barcode'];
      $_SESSION['user_role'] = $row_user['role'];
      $user_id = $row_user['id'];
      $stm = $pdo->prepare("SELECT id_group FROM users_groups WHERE id_user = $user_id");
      $stm->execute();
      $data_groups = $stm->fetchAll();
      $_SESSION['user_group'] = $data_groups;
      addEvent(0, $user, 'Login');
      echo '';
    } else {
      addEvent(1, $user, 'Invalid barcode');
      echo 'Invalid barcode';
    }
  }
}

// session data
if (isset($_SESSION['user_id'])) {
  $user_id = $_SESSION['user_id'];
  $user_barcode = $_SESSION['user_barcode'];
  $user_role = $_SESSION['user_role'];
  $user_group = $_SESSION['user_group'];
}

// group form
if (isset($_POST['action_group'])) {
  // insert
  if ($_POST['action_group'] == 'insert') {
    $name = filterInput($_POST['name_group']);
    $comment = filterInput($_POST['comment_group']);
    $stm = $pdo->prepare("SELECT COUNT(*) FROM groups WHERE name = :name");
    $stm->bindValue(':name', $name);
    $stm->execute();
    $count_name = $stm->fetchColumn();
    if (isset($count_name) && $count_name > 0) {
      echo 'Name exist';
    } else {
      $stm = $pdo->prepare("INSERT INTO groups (name, comment) VALUES (:name, :comment)");
      $stm->bindValue(':name', $name);
      $stm->bindValue(':comment', $comment);
      $stm->execute();
      addEvent(0, $user_barcode, "Add Group: $name");
    }
  }
  // update
  if ($_POST['action_group'] == 'update') {
    $id = $_POST['id_edit_group'];
    $name = filterInput($_POST['name_group']);
    $comment = filterInput($_POST['comment_group']);
    $name_edit = $_POST['name_edit_group'];
    if ($name != $name_edit) {
      $stm = $pdo->prepare("SELECT COUNT(*) FROM groups WHERE name = :name");
      $stm->bindValue(':name', $name);
      $stm->execute();
      $count_name = $stm->fetchColumn();
    }
    if (isset($count_name) && $count_name > 0 ) {
      echo 'Name exist';
    } else {
      $stm = $pdo->prepare("UPDATE groups SET name = :name, comment = :comment WHERE id = $id");
      $stm->bindValue(':name', $name);
      $stm->bindValue(':comment', $comment);
      $stm->execute();
      addEvent(0, $user_barcode, "Edit Group: $name");
    }
  }
}

// user form
if (isset($_POST['action_user'])) {
  // insert
  if ($_POST['action_user'] == 'insert') {
    $barcode = filterInput($_POST['barcode_user']);
    $stm = $pdo->prepare("SELECT COUNT(*) FROM users WHERE barcode = :barcode");
    $stm->bindValue(':barcode', $barcode);
    $stm->execute();
    $count_barcode = $stm->fetchColumn();
    if (isset($count_barcode) && $count_barcode > 0) {
      echo 'Barcode exist';
    } else {
      if (isset($_POST['role_user'])) {
        $role = $_POST['role_user'];
      } else {
        $role = 'TL';
      }
      $comment = filterInput($_POST['comment_user']);
      $stm = $pdo->prepare("INSERT INTO users (barcode, role, comment) VALUES (:barcode, :role, :comment)");
      $stm->bindValue(':barcode', $barcode);
      $stm->bindValue(':role', $role);
      $stm->bindValue(':comment', $comment);
      $stm->execute();
      $user_id = $pdo->lastInsertId();
      if (isset($_POST['group_user'])) {
        foreach ($_POST['group_user'] as $selected) {
          $stm = $pdo->prepare("INSERT INTO users_groups (id_user, id_group) VALUES ($user_id, $selected)");
          $stm->execute();
        }
      }
      addEvent(0, $user_barcode, "Add User: $barcode");
    }
  }
  // update
  if ($_POST['action_user'] == 'update') {
    $barcode = filterInput($_POST['barcode_user']);
    $barcode_edit = $_POST['barcode_edit_user'];
    if ($barcode != $barcode_edit) {
      $stm = $pdo->prepare("SELECT COUNT(*) FROM users WHERE barcode = :barcode");
      $stm->bindValue(':barcode', $barcode);
      $stm->execute();
      $count_barcode = $stm->fetchColumn();
    }
    if (isset($count_barcode) && $count_barcode > 0) {
      echo 'Barcode exist';
    } else {
      $id = $_POST['id_edit_user'];
      if (isset($_POST['role_user'])) {
        $role = $_POST['role_user'];
      } else {
        $role = 'TL';
      }
      $comment = filterInput($_POST['comment_user']);
      $stm = $pdo->prepare("UPDATE users SET barcode = :barcode, role = :role, comment = :comment WHERE id = $id");
      $stm->bindValue(':barcode', $barcode);
      $stm->bindValue(':role', $role);
      $stm->bindValue(':comment', $comment);
      $stm->execute();
      $stm = $pdo->prepare("DELETE FROM users_groups WHERE id_user = $id");
      $stm->execute();
      if (isset($_POST['group_user'])) {
        foreach ($_POST['group_user'] as $selected) {
          $stm = $pdo->prepare("INSERT INTO users_groups (id_user, id_group) VALUES ($id, $selected)");
          $stm->execute();
        }
      }
      addEvent(0, $user_barcode, "Edit User: $barcode");
    }
  }
}

// team form
if (isset($_POST['action_team'])) {
  // insert
  if ($_POST['action_team'] == 'insert') {
    $name = filterInput($_POST['name_team']);
    $comment = filterInput($_POST['comment_team']);
    $stm = $pdo->prepare("SELECT COUNT(*) FROM teams WHERE name = :name");
    $stm->bindValue(':name', $name);
    $stm->execute();
    $count_name = $stm->fetchColumn();
    if (isset($count_name) && $count_name > 0 ) {
      echo 'Name exist';
    } else {
      $stm = $pdo->prepare("INSERT INTO teams (name, comment) VALUES (:name, :comment)");
      $stm->bindValue(':name', $name);
      $stm->bindValue(':comment', $comment);
      $stm->execute();
      $team_id = $pdo->lastInsertId();
      if (isset($_POST['owner_team'])) {
        foreach ($_POST['owner_team'] as $selected) {
          $stm = $pdo->prepare("INSERT INTO teams_users (id_team, id_user) VALUES ($team_id, $selected)");
          $stm->execute();
        }
      } else {
        $stm = $pdo->prepare("INSERT INTO teams_users (id_team, id_user) VALUES ($team_id, $user_id)");
        $stm->execute();
      }
      addEvent(0, $user_barcode, "Add Team: $name");
    }
  }
  // update
  if ($_POST['action_team'] == 'update') {
    $id = $_POST['id_edit_team'];
    $name = filterInput($_POST['name_team']);
    $comment = filterInput($_POST['comment_team']);
    $name_edit = $_POST['name_edit_team'];
    if ($name != $name_edit) {
      $stm = $pdo->prepare("SELECT COUNT(*) FROM teams WHERE name = :name");
      $stm->bindValue(':name', $name);
      $stm->execute();
      $count_name = $stm->fetchColumn();
    }
    if (isset($count_name) && $count_name > 0 ) {
      echo 'Name exist';
    } else {
      $stm = $pdo->prepare("UPDATE teams SET name = :name, comment = :comment WHERE id = $id");
      $stm->bindValue(':name', $name);
      $stm->bindValue(':comment', $comment);
      $stm->execute();
      $stm = $pdo->prepare("DELETE FROM teams_users WHERE id_team = $id");
      $stm->execute();
      if (isset($_POST['owner_team'])) {
        foreach ($_POST['owner_team'] as $selected) {
          $stm = $pdo->prepare("INSERT INTO teams_users (id_team, id_user) VALUES ($id, $selected)");
          $stm->execute();
        }
      } else {
        $stm = $pdo->prepare("INSERT INTO teams_users (id_team, id_user) VALUES ($id, $user_id)");
        $stm->execute();
      }
      addEvent(0, $user_barcode, "Edit Team: $name");
    }
  }
}

// employee form
if (isset($_POST['action_employee'])) {
  // insert
  if ($_POST['action_employee'] == 'insert') {
    $barcode = filterInput($_POST['barcode_employee']);
    $team_id = $_POST['team_employee'];
    $comment = filterInput($_POST['comment_employee']);
    $stm = $pdo->prepare("SELECT COUNT(*) FROM employees WHERE barcode = :barcode");
    $stm->bindValue(':barcode', $barcode);
    $stm->execute();
    $count_barcode = $stm->fetchColumn();
    if (isset($count_barcode) && $count_barcode > 0 ) {
      echo 'Barcode exist';
    } else {
      $stm = $pdo->prepare("INSERT INTO employees (barcode, comment) VALUES (:barcode, :comment)");
      $stm->bindValue(':barcode', $barcode);
      $stm->bindValue(':comment', $comment);
      $stm->execute();
      $employee_id = $pdo->lastInsertId();
      $stm = $pdo->prepare("INSERT INTO teams_employees (id_team, id_employee) VALUES ($team_id, $employee_id)");
      $stm->execute();
      addEvent(0, $user_barcode, "Add Employee: $barcode");
    }
  }
  // update
  if ($_POST['action_employee'] == 'update') {
    $id = $_POST['id_edit_employee'];
    $barcode = filterInput($_POST['barcode_employee']);
    $team_id = $_POST['team_employee'];
    $comment = filterInput($_POST['comment_employee']);
    $barcode_edit = $_POST['barcode_edit_employee'];
    if ($barcode != $barcode_edit) {
      $stm = $pdo->prepare("SELECT COUNT(*) FROM employees WHERE barcode = :barcode");
      $stm->bindValue(':barcode', $barcode);
      $stm->execute();
      $count_barcode = $stm->fetchColumn();
    }
    if (isset($count_barcode) && $count_barcode > 0 ) {
      echo 'Barcode exist';
    } else {
      $stm = $pdo->prepare("UPDATE employees SET barcode = :barcode, comment = :comment WHERE id = $id");
      $stm->bindValue(':barcode', $barcode);
      $stm->bindValue(':comment', $comment);
      $stm->execute();
      $stm = $pdo->prepare("UPDATE teams_employees SET id_team = $team_id WHERE id_employee = $id");
      $stm->execute();
      addEvent(0, $user_barcode, "Edit Employee: $barcode");
    }
  }
}

// notification form
if (isset($_POST['action_notification'])) {
  if ($_POST['action_notification'] == 'insert') {
    if (!isset($_POST['team']) && !isset($_POST['employee']) && empty($_POST['text'])) {
      $output['team_employee_message'] = 'Select Team or Employee';
      $output['text_message'] = 'Insert Text';
    }
    if (!isset($_POST['team']) && !isset($_POST['employee'])) {
      $output['team_employee_message'] = 'Select Team or Employee';
    }
    if (empty($_POST['text'])) {
      $output['text_message'] = 'Insert Text';
    }
    if ((isset($_POST['team']) || isset($_POST['employee'])) && !empty($_POST['text'])) {
      $text = filterInput($_POST['text']);
      $date = date('Y-m-d H:i:s');
      $stm = $pdo->prepare("INSERT INTO notifications (text) VALUES (:text)");
      $stm->bindValue(':text', $text);
      $stm->execute();
      $notification_id = $pdo->lastInsertId();
      if (isset($_POST['team'])) {
        foreach ($_POST['team'] as $selected) {
          $stm = $pdo->prepare("INSERT INTO notifications_send (recipient_type, id_recipient, id_notification, id_user, date, state) VALUES ('1', $selected, $notification_id, $user_id, :date, '1')");
          $stm->bindValue(':date', $date);
          $stm->execute();
          $notification_send_id = $pdo->lastInsertId();
          $stm = $pdo->prepare("SELECT id_employee FROM teams_employees WHERE id_team = $selected");
          $stm->execute();
          $data_employees = $stm->fetchAll();
          foreach ($data_employees as $row_employee) {
            $employee_id = $row_employee['id_employee'];
            if ($employee_id != '') {
              $stm = $pdo->prepare("INSERT INTO notifications_queue (id_notification_send, id_notification, id_employee) VALUES ($notification_send_id,$notification_id, $employee_id)");
              $stm->execute();
            }
          }
        }
      }
      if (isset($_POST['employee'])) {
        foreach ($_POST['employee'] as $selected) {
          $stm = $pdo->prepare("INSERT INTO notifications_send (recipient_type, id_recipient, id_notification, id_user, date, state) VALUES ('2', $selected, $notification_id, $user_id, :date, '1')");
          $stm->bindValue(':date', $date);
          $stm->execute();
          $notification_send_id = $pdo->lastInsertId();
          $stm = $pdo->prepare("SELECT id FROM employees WHERE id = $selected");
          $stm->execute();
          $data_employees = $stm->fetchAll();
          foreach ($data_employees as $row_employee) {
            $employee_id = $row_employee['id'];
            if ($employee_id != '') {
              $stm = $pdo->prepare("INSERT INTO notifications_queue (id_notification_send, id_notification, id_employee) VALUES ($notification_send_id,$notification_id, $employee_id)");
              $stm->execute();
            }
          }
        } 
      }
      addEvent(0, $user_barcode, "Send Notification");
      echo json_encode(null);
    } else {
      echo json_encode($output);
    }
  }
}

// fetch group, user, team, employee
if (isset($_POST['action_fetch'])) {
  if ($_POST['action_fetch'] == 'fetch') {
    $id = $_POST['id'];
    // group
    if ($_POST['type'] == 'groups') {
      $stm = $pdo->prepare("SELECT * FROM groups WHERE id = $id");
      $stm->execute();
      $row_group = $stm->fetch();
      $output['name'] = $row_group['name'];
      $output['comment'] = $row_group['comment'];
    }
    // user
    if ($_POST['type'] == 'users') {
      $stm = $pdo->prepare("SELECT * FROM users WHERE id = $id");
      $stm->execute();
      $row_user = $stm->fetch();
      $output['barcode'] = $row_user['barcode'];
      $output['role'] = $row_user['role'];
      $group_id = groups('groups_user', $id, 'id');
      $output['id_group'] = $group_id;
      $output['comment'] = $row_user['comment'];
    }
    // team
    if ($_POST['type'] == 'teams') {
      $stm = $pdo->prepare("SELECT teams.name, teams.comment FROM teams LEFT JOIN teams_users ON teams_users.id_team = teams.id WHERE teams.id = $id");
      $stm->execute();
      $row_team = $stm->fetch();
      $output['name'] = $row_team['name'];
      $owner_id = owners('owners_team', $id, 'id');
      $output['id_owner'] = $owner_id;
      $output['comment'] = $row_team['comment'];
    }
    // employee
    if ($_POST['type'] == 'employees') {
      $stm = $pdo->prepare("SELECT employees.barcode, employees.comment, teams_employees.id_team FROM employees LEFT JOIN teams_employees ON teams_employees.id_employee = employees.id WHERE employees.id = $id");
      $stm->execute();
      $row_employee = $stm->fetch();
      $output['barcode'] = $row_employee['barcode'];
      $output['id_team'] = $row_employee['id_team'];
      $output['comment'] = $row_employee['comment'];
    }
    echo json_encode($output);
  }
}

// delete group, user, team, employee, notification
if (isset($_POST['action_delete'])) {
  if ($_POST['action_delete'] == 'delete') {
    $id = $_POST['id_delete'];
    // groups
    if ($_POST['type_delete'] == 'groups') {
      $stm = $pdo->prepare("SELECT name FROM groups WHERE id = $id");
      $stm->execute();
      $row_name = $stm->fetch();
      $name = $row_name['name'];
      $stm = $pdo->prepare("DELETE FROM groups WHERE id = $id");
      $stm->execute();
      addEvent(0, $user_barcode, "Delete Group: $name");
    }
    // users
    if ($_POST['type_delete'] == 'users') {
      $stm = $pdo->prepare("SELECT barcode FROM users WHERE id = $id");
      $stm->execute();
      $row_name = $stm->fetch();
      $name = $row_name['name'];
      $stm = $pdo->prepare("DELETE FROM users WHERE id = $id");
      $stm->execute();
      $stm = $pdo->prepare("DELETE FROM users_groups WHERE id_user = $id");
      $stm->execute();
      addEvent(0, $user_barcode, "Delete User: $barcode");
    }
    // teams
    if ($_POST['type_delete'] == 'teams') {
      $stm = $pdo->prepare("SELECT name FROM teams WHERE id = $id");
      $stm->execute();
      $row_name = $stm->fetch();
      $name = $row_name['name'];
      $stm = $pdo->prepare("DELETE FROM teams WHERE id = $id");
      $stm->execute();
      $stm = $pdo->prepare("DELETE FROM teams_users WHERE id_team = $id");
      $stm->execute();
      addEvent(0, $user_barcode, "Delete Team: $name");
    }
    // employees
    if ($_POST['type_delete'] == 'employees') {
      $stm = $pdo->prepare("SELECT barcode FROM employees WHERE id = $id");
      $stm->execute();
      $row_name = $stm->fetch();
      $barcode = $row_name['barcode'];
      $stm = $pdo->prepare("DELETE FROM employees WHERE id = $id");
      $stm->execute();
      $stm = $pdo->prepare("DELETE FROM teams_employees WHERE id_employee = $id");
      $stm->execute();
      addEvent(0, $user_barcode, "Delete Employee: $barcode");
    }
    // notifications
    if ($_POST['type_delete'] == 'notifications') {
      $stm = $pdo->prepare("DELETE FROM notifications_queue WHERE id_notification_send = $id");
      $stm->execute();
      $stm = $pdo->prepare("UPDATE notifications_send SET state = '2' WHERE id = $id");
      $stm->execute();
      addEvent(0, $user_barcode, "Delete Notification");
    }
  }
}
?>