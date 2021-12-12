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
<input type="hidden" id="type" value="notifications" />
<div class="content-wrapper">
  <div id="hide_item" class="hide-item">
    <section class="content-header">
      <h1>
      Notifications
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
            <button type="button" name="new_notification" id="new_notification" class="btn btn-flat btn-orange pull-right" style="width: 70px;" title="New Notification"><i class="fa fa-plus"></i>&nbsp New</button>
          </div>
        </div>
        <div class="box-body">
          <table id="table_notifications" class="table table table-condensed table-striped" width="100%">
            <thead style="background-color:#f9f9f9">
              <tr>
                <th>Date</th>
                <th>Recipient</th>
                <th>Text</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
            <?php
            $array_notifications = notificationsList($user_role, $user_group, $user_id);
            foreach ($array_notifications as $value_notification) {
            ?>
              <tr>
                <td><?php echo $value_notification['date']; ?></td>
                <td><?php echo $value_notification['recipient']; ?></td>
                <td><?php echo $value_notification['text']; ?></td>
                <td>
                <?php if ($value_notification['state'] != 2) { ?>
                  <button type="button" name="delete" id="<?php echo $value_notification['id']; ?>" class="btn btn-flat btn-trans btn-xs delete" title="Delete"><i class="glyphicon glyphicon-trash"></i>&nbsp; Delete</button>
                <?php } else { ?>
                  <button type="button" name="deleted" class="btn btn-flat btn-trans btn-xs disabled" title="Deleted"><i class="glyphicon glyphicon-remove"></i>&nbsp; Deleted</button>
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