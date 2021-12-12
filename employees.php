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
<input type="hidden" id="type" value="employees" />
<div class="content-wrapper">
  <div id="hide_item" class="hide-item">
    <section class="content-header">
      <h1>
        Employees
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
            <button type="button" name="add_employee" id="add_employee" class="btn btn-flat btn-orange pull-right" style="width: 70px;" title="Add Employee"><i class="fa fa-plus"></i>&nbsp Add</button>
          </div>
        </div>
        <div class="box-body">
          <table id="table_employees" class="table table table-condensed table-striped" width="100%">
            <thead style="background-color:#f9f9f9">
              <tr>
                <th>Barcode</th>
                <th>Team</th>
                <th>Comment</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
            <?php
            $array_employees = employeesList($user_role, $user_group, $user_id);
            foreach ($array_employees as $value_employee) {
            ?>
              <tr>
                <td><?php echo $value_employee['barcode']; ?></td>
                <td><?php echo $value_employee['name']; ?></td>
                <td><?php echo $value_employee['comment']; ?></td>
                <td>
                  <button type="button" name="edit" id="<?php echo $value_employee['id']; ?>" class="btn btn-flat btn-trans btn-xs edit" title="Edit"><i class="glyphicon glyphicon-edit"></i>&nbsp; Edit</button>
                  <button type="button" name="delete" id="<?php echo $value_employee['id']; ?>" class="btn btn-flat btn-trans btn-xs delete" title="Delete"><i class="glyphicon glyphicon-trash"></i>&nbsp; Delete</button>
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