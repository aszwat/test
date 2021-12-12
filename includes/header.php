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
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>duże litery
  <![endif]-->
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<body class="hold-transition fixed sidebar-mini">
  <div class="wrapper">
    <header class="main-header">
      <div class="logo" style="cursor: default;">
        <span class="logo-mini">ZK</span>
        <span class="logo-lg"><b>Z</b>al<b>K</b>om<span style="font-size: 75%;">&nbsp v0.2</span></span>
      </div>
      <nav class="navbar navbar-static-top">
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
          <span class="sr-only">Toggle navigation</span>
        </a>
        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <span><?php echo $_SESSION['user_barcode']; ?></span>
              </a>
              <ul class="dropdown-menu shadow" style="cursor: pointer;">
                <li>
                  <a data-toggle="modal" data-target="#modal_logout"><i class="fa fa-sign-out"></i>&nbsp Sign Out</a>
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </nav>
    </header>