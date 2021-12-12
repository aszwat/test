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
<input type="hidden" id="type" value="teams" />
<div class="content-wrapper">
  <div id="hide_item" class="hide-item">
    <section class="content-header">
      <h1>
        Teams
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
            <button type="button" name="add_team" id="add_team" class="btn btn-flat btn-orange pull-right" style="width: 70px;" title="Add Team"><i class="fa fa-plus"></i>&nbsp Add</button>
          </div>
        </div>
        <div class="box-body">
          <table id="<?php if ($user_role == 'IT' OR  $user_role == 'AM') { echo 'table_teams'; } else { echo 'table_teams_tl'; } ?>" class="table table table-condensed table-striped" width="100%">
            <thead style="background-color:#f9f9f9">
              <tr>
                <th>Name</th>
                <?php if ($user_role == 'IT' OR  $user_role == 'AM') { ?><th>Owner</th><?php } ?>
                <th>Employess</th>
                <th>Comment</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
            <?php
            $array_teams = teamsList($user_role, $user_group, $user_id);
            foreach ($array_teams as $value_team) {
              $team_id = $value_team['id'];
              $stm = $pdo->prepare("SELECT COUNT(*) FROM teams_employees WHERE id_team = $team_id");
              $stm->execute();
              $count_employees = $stm->fetchColumn();
            ?>
              <tr>
                <td><?php echo $value_team['name']; ?></td>
                <?php if ($user_role == 'IT' OR  $user_role == 'AM') { ?><td><?php echo $value_team['owner']; ?></td><?php } ?>
                <td><?php echo $count_employees; ?></td>
                <td><?php echo $value_team['comment']; ?></td>
                <td>
                  <button type="button" name="edit" id="<?php echo $value_team['id']; ?>" class="btn btn-flat btn-trans btn-xs edit" title="Edit"><i class="glyphicon glyphicon-edit"></i>&nbsp; Edit</button>
                  <button type="button" name="delete" id="<?php echo $value_team['id']; ?>" class="btn btn-flat btn-trans btn-xs delete" title="Delete"><i class="glyphicon glyphicon-trash"></i>&nbsp; Delete</button>
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