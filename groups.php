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
<input type="hidden" id="type" value="groups" />
<div class="content-wrapper">
  <div id="hide_item" class="hide-item">
    <section class="content-header">
      <h1>
        Groups
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
            <button type="button" name="add_group" id="add_group" class="btn btn-flat btn-orange pull-right" style="width: 70px;" title="Add Group"><i class="fa fa-plus"></i>&nbsp Add</button>
          </div>
        </div>
        <div class="box-body">
          <table id="table_groups" class="table table table-condensed table-striped" width="100%">
            <thead style="background-color:#f9f9f9">
              <tr>
                <th>Name</th>
                <th>Users</th>
                <th>Comment</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
            <?php
            $stm = $pdo->prepare("SELECT * FROM groups");
            $stm->execute();
            $data_groups = $stm->fetchAll();
            foreach ($data_groups as $row_group) {
              $group_id = $row_group['id'];
              $stm = $pdo->prepare("SELECT COUNT(*) FROM users_groups WHERE id_group = $group_id");
              $stm->execute();
              $count_users = $stm->fetchColumn();
            ?>
              <tr>
                <td><?php echo $row_group['name']; ?></td>
                <td><?php echo $count_users; ?></td>
                <td><?php echo $row_group['comment']; ?></td>
                <td>
                  <button type="button" name="edit" id="<?php echo $row_group['id']; ?>" class="btn btn-flat btn-trans btn-xs edit" title="Edit"><i class="glyphicon glyphicon-edit"></i>&nbsp; Edit</button>
                  <?php if ($row_group['id'] != 1) { ?>
                  <button type="button" name="delete" id="<?php echo $row_group['id']; ?>" class="btn btn-flat btn-trans btn-xs delete" title="Delete"><i class="glyphicon glyphicon-trash"></i>&nbsp; Delete</button>
                  <?php } ?>
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