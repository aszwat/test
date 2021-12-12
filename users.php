<?php
  session_start();
  if (!isset($_SESSION['logged'])) {
    header('Location: login.php');
    exit();
  }
  include 'includes/actions.php';
  include 'includes/header.php';
  include 'includes/sidebar.php';
?>
<input type="hidden" id="type" value="users" />
<div class="content-wrapper">
  <div id="hide_item" class="hide-item">
    <section class="content-header">
      <h1>
        Users
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li class="active">Made by WHIT Szczecin</li>
      </ol>
    </section>
    <section class="content">
      <div class="box">
        <div class="box-header">
          <div>
            <button type="button" name="add_user" id="add_user" class="btn btn-flat btn-orange pull-right" style="width: 70px;" title="Add User"><i class="fa fa-plus"></i>&nbsp Add</button>
          </div>
        </div>
        <div class="box-body">
          <table id="<?php if ($user_role == 'IT') { echo 'table_users'; } else { echo 'table_users_am_tl'; } ?>" class="table table table-condensed table-striped" width="100%">
            <thead style="background-color:#f9f9f9">
              <tr>
                <th>Barcode</th>
                <?php if ($user_role == 'IT') { ?><th>Role</th><?php } ?>
                <th>Group</th>
                <th>Comment</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
            <?php
            $array_users = usersList($user_role, $user_group);
            foreach ($array_users as $value_user) {
            ?>
              <tr>
                <td><?php echo $value_user['barcode']; ?></td>
                <?php if ($user_role == 'IT') { ?><td><?php echo $value_user['role']; ?></td><?php } ?>
                <td><?php echo $value_user['group']; ?></td>
                <td><?php echo $value_user['comment']; ?></td>
                <td>
                  <button type="button" name="edit" id="<?php echo $value_user['id']; ?>" class="btn btn-flat btn-trans btn-xs edit" title="Edit"><i class="glyphicon glyphicon-edit"></i>&nbsp; Edit</button>
                  <button type="button" name="delete" id="<?php echo $value_user['id']; ?>" class="btn btn-flat btn-trans btn-xs delete" title="Delete"><i class="glyphicon glyphicon-trash"></i>&nbsp; Delete</button>
                </td>
              </tr>
            <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </section>
  </div>
</div>
<?php include 'includes/footer.php'; ?>