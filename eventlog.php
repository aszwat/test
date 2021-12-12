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
<div class="content-wrapper">
  <div id="hide_item" class="hide-item">
    <section class="content-header">
      <h1>
        Event Log
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
          </div>
        </div>
        <div class="box-body">
          <table id="table_events" class="table table table-condensed table-striped" width="100%">
            <thead style="background-color:#f9f9f9">
              <tr>
                <th>Type</th>
                <th>Date</th>
                <th>User</th>
                <th>IP</th>
                <th>Message</th>
              </tr>
            </thead>
            <tbody>
            <?php
            $stm = $pdo->prepare("SELECT * FROM events");
            $stm->execute();
            $data_events = $stm->fetchAll();
            foreach ($data_events as $row_event) {
            ?>
              <tr>
                <td><span class="badge-custom" <?php if ($row_event['type'] == 1) { echo 'style="color: #dd4b39;"'; } ?>><?php if ($row_event['type'] == 1) { echo 'ERROR'; } else { echo '&nbsp; INFO &nbsp;'; } ?></span></td>
                <td <?php if ($row_event['type'] == 1) { echo 'style="color: #dd4b39;"'; } ?>><?php echo $row_event['date']; ?></td>
                <td <?php if ($row_event['type'] == 1) { echo 'style="color: #dd4b39;"'; } ?>><?php echo $row_event['user']; ?></td>
                <td <?php if ($row_event['type'] == 1) { echo 'style="color: #dd4b39;"'; } ?>><?php echo $row_event['ip']; ?></td>
                <td <?php if ($row_event['type'] == 1) {  echo 'style="color: #dd4b39;"'; } ?>><?php echo $row_event['message']; ?></td>
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