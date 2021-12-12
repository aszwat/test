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
  <div id="hide_item_" class="hide-item_">
    <a id="top" title="Top" href="#">&#10148;</a>
    <section class="content-header">
      <h1>
        Dashboard
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li class="active">Made by WHIT Szczecin</li>
      </ol>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box" style="box-shadow: none; background: #f39c121a; margin-bottom: 20px;">
            <span class="info-box-icon bg-yellow"><i class="fa fa-envelope"></i></span>
            <div class="info-box-content">
              <button type="button" name="new_notification" id="new_notification" class="btn btn-flat btn-trans btn-xs pull-right" title="New Notification"><span class="glyphicon glyphicon-plus"></span></button>
              <span class="info-box-text" title="Notifications"><a style="color: #333" href="notifications.php">Notifications</a></span>
              <span class="info-box-number"><?php //echo count(notifications()); ?></span>
            </div>
          </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box" style="box-shadow: none; background: #dd4b391a; margin-bottom: 20px;">
            <span class="info-box-icon bg-red"><i class="fa fa-users"></i></span>
            <div class="info-box-content">
              <button type="button" name="add_employee" id="add_employee" class="btn btn-flat btn-trans btn-xs pull-right" title="Add Employee"><span class="glyphicon glyphicon-plus"></span></button>
              <span class="info-box-text" title="Employees"><a style="color: #333" href="employees.php">Employees</a></span>
              <span class="info-box-number"><?php //echo count(employees()); ?></span>
            </div>
          </div>
        </div>
        <div class="clearfix visible-sm-block"></div>
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box" style="box-shadow: none; background: #00a65a1a; margin-bottom: 20px;">
            <span class="info-box-icon bg-green"><i class="fa fa-users"></i></span>
            <div class="info-box-content">
              <button type="button" name="add_team" id="add_team" class="btn btn-flat btn-trans btn-xs pull-right" title="Add Team"><span class="glyphicon glyphicon-plus"></span></button>
              <span class="info-box-text" title="Teams"><a style="color: #333" href="teams.php">Teams</a></span>
              <span class="info-box-number"><?php //echo count(teams()); ?><small></small></span>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</div>
<?php include 'includes/footer.php'; ?>