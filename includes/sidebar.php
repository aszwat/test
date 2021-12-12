<aside class="main-sidebar">
  <section class="sidebar">
    <ul class="sidebar-menu" data-widget="tree">
      <li class="header">NAVIGATION</li>
      <li title="Dashboard"><a href="dashboard.php"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
      <li title="Teams"><a href="teams.php"><i class="fa fa-group"></i> <span>Teams</span></a></li>
      <li title="Employees"><a href="employees.php"><i class="fa fa-group"></i> <span>Employees</span></a></li>
      <li title="Notifications"><a href="notifications.php"><i class="fa fa-comments"></i> <span>Notifications</span></a></li>
      <?php if ($user_role != 'TL') { ?>
      <li class="treeview">
        <a href="#"><i class="fa fa-gears"></i> <span>Administration</span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
        <ul class="treeview-menu">
          <li>
            <li title="Users"><a href="users.php">&nbsp <i class="fa fa-group"></i> <span>Users</span></a></li>
          </li>
          <?php if ($user_role != 'AM') { ?>
          <li>
            <li title="Groups"><a href="groups.php">&nbsp <i class="fa fa-group"></i> <span>Groups</span></a></li>
          </li>
          <li>
            <li title="Event Log"><a href="eventlog.php">&nbsp <i class="fa fa-book"></i> <span>Event Log</span></a></li>
          </li>
          <?php } ?>
        </ul>
      </li>
      <?php } ?>
    </ul>
  </section>
</aside>