<?php
  session_start();
  if (isset($_SESSION['logged'])) {
    header('Location: dashboard.php');
    exit();
  }
  include 'includes/actions.php';
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>ZalKom</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="css/font-awesome/css/font-awesome.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="css/select2.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="css/AdminLTE.min.css">
  <!-- main css file -->
  <link rel="stylesheet" href="css/main.min.css">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">
      <b>Z</b>al<b>K</b>om
    </div>
    <div class="login-box-body shadow">
      <p class="login-box-msg">Enter your barcode:</p>
      <form method="post" id="form_login">
        <div id="login_class">
          <input type="hidden" name="action_login" id="action_login" value="login" />

          <!-- problem ze znakami sffdfs "" w loginie -->
          
          <input type="text" name="user" id="user" class="form-control" placeholder="Barcode" autocomplete="off" maxlength="15" required autofocus />
          <span id="login_message" class="help-block"></span>
        </div>
        <div class="row">
          <div class="col-md-12">
            <input type="submit" value="Login" class="btn btn-flat btn-block btn-orange" style="margin-top: 5px;" title="Login" />
          </div>
        </div>
      </form>
    </div>
  </div>
  <!-- jQuery 3 -->
  <script src="js/jquery.min.js"></script>
  <!-- Bootstrap 3.3.7 -->
  <script src="js/bootstrap.min.js"></script>
  <!-- Select2 -->
  <script src="js/select2.full.min.js"></script>
  <!-- DataTables -->
  <script src="js/jquery.dataTables.min.js"></script>
  <script src="js/jquery.mark.min.js"></script>
  <script src="js/dataTables.bootstrap.min.js"></script>
  <!-- AdminLTE App -->
  <script src="js/adminlte.min.js"></script>
  <!-- page script -->
  <script src="js/main.min.js"></script>
  <script>
    if (window.history.replaceState) {
      window.history.replaceState(null, null, window.location.href);
    }
  </script>
</body>

</html>