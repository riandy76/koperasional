<?php 
	//cek apakah sudah login ??
	include ('../config/lock.php');
?>

<!DOCTYPE html>
<html lang="en">  
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Aplikasi Keuangan - Bagian Operasional</title>

    <!-- Bootstrap -->
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="../assets/css/AdminLTE.min.css" rel="stylesheet">
    <link href="../assets/css/skins/skin-blue.min.css" rel="stylesheet">
    <link href="../assets/js/jquery-ui-1.12.1/jquery-ui.min.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
  <!-- Main Header -->
  <header class="main-header">
    <!-- Logo -->
    <a href="dashboard.php" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <!-- <span class="logo-mini"><b>A</b>LT</span> -->
      <!-- logo for regular state and mobile devices -->
      <span class="logo-mini"><b><span class="glyphicon glyphicon-home"></span></b></span>
      <span class="logo-lg"><b><span class="glyphicon glyphicon-home"></span> Home</b></span>
    </a>

<!-- Awal Nav -->
<nav class="navbar navbar-default" role="navigation">
  <!-- Sidebar toggle button-->
  <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
    <span class="sr-only">Toggle navigation</span>
  </a>

<!-- Navbar Right Menu -->
<div class="navbar-custom-menu">
<ul class="nav navbar-nav">
          <li class="dropdown user user-menu">
            <!-- Menu Toggle Button -->
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <!-- The user image in the navbar-->
              <img src="../assets/images/<?php echo $user->pic; ?>" class="user-image" alt="User Image">
              <!-- hidden-xs hides the username on small devices so only the image appears. -->
              <span class="hidden-xs">
              <?php echo $user->nama; ?>
              </span>
            </a>
            <ul class="dropdown-menu">
              <!-- The user image in the menu -->
              <li class="user-header">
                <img src="../assets/images/<?php echo $user->pic; ?>" class="img-circle" alt="User Image">

                <p>
                  <?php echo $user->nama; ?>
                  <small><?php
                  echo '<br>Login terakhir pada '. $time;
                  ?></small>
                </p>
              </li>
              <!-- Menu Body -->
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="#" class="btn btn-default btn-flat" id="atur_user">Pengaturan</a>
                </div>
                <div class="pull-right">
                  <a title="Keluar dari aplikasi" href="logout.php" class="btn btn-default btn-flat">Keluar</a>
                </div>
              </li>
            </ul>
          </li>
</ul>
</div>
</nav>
</header>
<!-- Main Header -->

<!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel (optional) -->
<!--       <div class="user-panel">
        <div class="pull-left image">
          <img src="../assets/images/profil.png" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php echo $user->nama; ?></p>
        </div>
      </div> -->

<!-- Sidebar Menu -->
<ul class="sidebar-menu" data-widget="tree">
<!-- SIDEBAR MENU -->
<li class="header">MENU</li>
<!-- Optionally, you can add icons to the links -->
<li class="treeview">
  <a data-toggle="tooltip" title="Melihat Bukti - Bukti Kas Operasional Cabang" href="#">
  <i class="fa fa-link"></i> <span>CABANG</span>
    <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
    </span>
  </a>
    <ul class="treeview-menu">
      <li><a data-toggle="tooltip" title="Melihat Kas Operasional CABANG" href="#" id="do_cabang_kas_operasional">Kas Operasional</a></li>
      <li role="separator" class="divider"></li>
      <li><a data-toggle="tooltip" title="Melihat Kas Operasional - Kas Masuk CABANG" href="#" id="do_cabang_kas_masuk">Kas Masuk</a></li>
      <li><a data-toggle="tooltip" title="Melihat Kas Operasional - Uang Muka CABANG" href="#" id="do_cabang_uang_muka">Uang Muka</a></li>
      <li><a data-toggle="tooltip" title="Melihat Kas Operasional - Biaya CABANG" href="#" id="do_cabang_biaya">Biaya</a></li>
      <li><a data-toggle="tooltip" title="Melihat Kas Operasional - Bon Gantung CABANG" href="#" id="do_cabang_bon_gantung">Bon Gantung</a></li>
      <li role="separator" class="divider"></li>
      <li><a data-toggle="tooltip" title="Melihat Stok Kas Operasional CABANG" href="#" id="do_cabang_stok_kas">Stok Kas</a></li>
      <li><a data-toggle="tooltip" title="Melihat Laporan Biaya Kas Operasional CABANG" href="#" id="do_cabang_lap_kas">Laporan Biaya Kas Operasional</a></li>
    </ul>
</li>

<li class="treeview">
    <a data-toggle="tooltip" title="Melihat Bukti - Bukti Kas Operasional Pusat" href="#">
    <i class="fa fa-link"></i> <span>PUSAT</span>
    <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
    </span>
    </a>
      <ul class="treeview-menu">
      <li><a data-toggle="tooltip" title="Melihat Kas Operasional PUSAT" href="#" id="do_pusat_kas_operasional">Kas Operasional</a></li>
      <li role="separator" class="divider"></li>
      <li><a data-toggle="tooltip" title="Melihat Kas Operasional - Kas Masuk PUSAT" href="#" id="do_pusat_kas_masuk">Kas Masuk</a></li>
      <li><a data-toggle="tooltip" title="Melihat Kas Operasional - Uang Muka PUSAT" href="#" id="do_pusat_uang_muka">Uang Muka</a></li>
      <li><a data-toggle="tooltip" title="Melihat Kas Operasional - Biaya PUSAT" href="#" id="do_pusat_biaya">Biaya</a></li>
      <li><a data-toggle="tooltip" title="Melihat Kas Operasional - Bon Gantung PUSAT" href="#" id="do_pusat_bon_gantung">Bon Gantung</a></li>
      <li role="separator" class="divider"></li>
      <li><a data-toggle="tooltip" title="Melihat Stok Kas Operasional PUSAT" href="#" id="do_pusat_stok_kas">Stok Kas</a></li>
      <!-- <li><a title="Melihat Uang Muka Kas Operasional PUSAT" href="#" id="dropping">Dropping Kas</a></li> -->
      <li><a data-toggle="tooltip" title="Melihat Laporan Biaya Kas Operasional PUSAT" href="#" id="do_pusat_lap_kas">Laporan Biaya Kas Operasional</a></li>
      </ul>
</li>

<li class="treeview">
    <a data-toggle="tooltip" title="Setting Master Data" href="#">
    <i class="fa fa-link"></i> <span>MASTER</span>
    <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
    </span>
    </a>
      <ul class="treeview-menu">
        <li><a data-toggle="tooltip" title="Setting Awal Periode" href="#" id="do_saldo_awal">Saldo Awal Periode</a></li>
        <li><a data-toggle="tooltip" title="Setting Jenis Biaya" href="#" id="do_jenis_biaya">Jenis Biaya</a></li>
<!--         <li><a title="Melihat Uang Muka Kas Operasional PUSAT" href="#" id="biaya_pln">Data Tagihan PLN, PDAM, TELKOM</a></li> -->
        <li><a data-toggle="tooltip" title="Setting Data Pengguna Kas" href="#" id="do_pengguna">Data Pengguna Kas</a></li>
      </ul>
</li>
<!-- SIDEBAR SAMPAI SINI -->
</ul>
<!-- /.sidebar-menu -->
</section>
<!-- /.sidebar -->
</aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Aplikasi Keuangan
        <small>pada Bagian Operasional</small>
      </h1>
<!--       <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li>
      </ol> -->
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
      <!--| Your Page Content Here |-->
    <div id="page-wrapper">
    <!-- Page Wrapper untuk jquery .load() -->
    </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="pull-right hidden-xs">
      <!-- Anything you want -->
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2017 <a href="#">PT Bintang Global Sumber Sarana</a>.</strong> All rights reserved.
  </footer>

</div>
<!-- /.content-wrapper -->

  <script src="../assets/js/jquery-3.2.1.min.js"></script> 
  <script src="../assets/js/bootstrap.min.js"></script>
  <script src="../assets/js/jquery-ui-1.12.1/jquery-ui.min.js"></script>
  <script src="../assets/js/adminlte.min.js"></script>

<script>
    $( document ).ready(function() {
    $('[data-toggle="tooltip"]').tooltip();  
      var datePickerOptions = {
        dateFormat: "yy-mm-dd",
        changeMonth: true,
        changeYear: true,
        showOn: "button",
        buttonImage: "../assets/images/calendar.png",
        buttonImageOnly: true,
        buttonText: "Pilih Tanggal"
      }

      var datePickerOptions2 = {
        dateFormat: "yy-mm-dd",
        changeMonth: true,
        changeYear: true
      }

            $('#biaya_pln').click(function(){
                $('#page-wrapper').load('master/listrik_pln.php',
                  function(){

                  });
            });

            $('#do_pengguna').click(function(){
                $('#page-wrapper').load('master/pengguna.php',
                  function(){

                  });
            });

            $('#atur_user').click(function(){
                $('#page-wrapper').load('user/user.php',
                  function(){

                  });
            });

            $('#do_jenis_biaya').click(function(){
                $('#page-wrapper').load('master/jenis_biaya.php',
                  function(){

                  });
            });

/**================Pusat-===============**/
            $('#dropping').click(function(){
                $('#page-wrapper').load('ko-pusat/dropping.php',
                  function(){

                  });
            });

            $('#do_pusat_kas_operasional').click(function(){
                $('#page-wrapper').load('ko-pusat/kas_operasional.php',
                  function(){
                    $("#from_date").datepicker(datePickerOptions);
                    $("#from_date").datepicker("setDate", "today");
                    $('[data-toggle="tooltip"]').tooltip();
                  });
            });

            $('#do_saldo_awal').click(function(){
                $('#page-wrapper').load('master/do_saldo_awal.php',
                  function(){
                    $("#v_tggl_periode").datepicker(datePickerOptions2);
                    $("#v_tggl_periode").datepicker("setDate", "today");                    
                  });
            });

            $('#do_pusat_stok_kas').click(function(){
                $('#page-wrapper').load('ko-pusat/do_stok_kas.php',
                  function(){
                    $("#from_date").datepicker(datePickerOptions);
                    $("#from_date").datepicker("setDate", "today");
                    $('[data-toggle="tooltip"]').tooltip();
                  });
            });

            $('#do_pusat_lap_kas').click(function(){
                $('#page-wrapper').load('ko-pusat/lap_kas.php',
                  function(){
                    $("#from_date").datepicker(datePickerOptions);
                    $("#from_date").datepicker("setDate", "today");
                    $('[data-toggle="tooltip"]').tooltip();                
                  });
            });          

            $('#do_pusat_uang_muka').click(function(){
                $('#page-wrapper').load('ko-pusat/uang_muka.php',
                  function(){
                    $("#from_date").datepicker(datePickerOptions);
                    $("#from_date").datepicker("setDate", "today");
                  });
            });

            $('#do_pusat_biaya').click(function(){
                $('#page-wrapper').load('ko-pusat/biaya.php',
                  function(){
                    $("#from_date").datepicker(datePickerOptions);
                    $("#from_date").datepicker("setDate", "today");
                  });
            });

            $('#do_pusat_kas_masuk').click(function(){
                $('#page-wrapper').load('ko-pusat/kas_masuk.php',
                  function(){
                    $("#from_date").datepicker(datePickerOptions);
                    $("#from_date").datepicker("setDate", "today");
                  });
            });

            $('#do_pusat_bon_gantung').click(function(){
                $('#page-wrapper').load('ko-pusat/do_bon_gantung.php',
                  function(){
                    $("#from_date").datepicker(datePickerOptions);
                    $("#from_date").datepicker("setDate", "today");
                  });
            });

/**================Cabang-===============**/
            $('#do_cabang_lap_kas').click(function(){
                $('#page-wrapper').load('ko-cabang/lap_kas.php',
                  function(){
                    $("#from_date").datepicker(datePickerOptions);
                    $("#from_date").datepicker("setDate", "today");
                    $('[data-toggle="tooltip"]').tooltip();                
                  });
            });

            $('#do_cabang_kas_operasional').click(function(){
                $('#page-wrapper').load('ko-cabang/kas_operasional.php',
                  function(){
                    $("#from_date").datepicker(datePickerOptions);
                    $("#from_date").datepicker("setDate", "today");
                  });
            });

            $('#do_cabang_stok_kas').click(function(){
                $('#page-wrapper').load('ko-cabang/do_stok_kas.php',
                  function(){
                    $("#from_date").datepicker(datePickerOptions);
                    $("#from_date").datepicker("setDate", "today");
                  });
            });

            $('#do_cabang_uang_muka').click(function(){
                $('#page-wrapper').load('ko-cabang/uang_muka.php',
                  function(){
                    $("#from_date").datepicker(datePickerOptions);
                    $("#from_date").datepicker("setDate", "today");
                  });
            });

            $('#do_cabang_biaya').click(function(){
                $('#page-wrapper').load('ko-cabang/biaya.php',
                  function(){
                    $("#from_date").datepicker(datePickerOptions);
                    $("#from_date").datepicker("setDate", "today");
                  });
            });

            $('#do_cabang_kas_masuk').click(function(){
                $('#page-wrapper').load('ko-cabang/kas_masuk.php',
                  function(){
                    $("#from_date").datepicker(datePickerOptions);
                    $("#from_date").datepicker("setDate", "today");
                  });
            });

            $('#do_cabang_bon_gantung').click(function(){
                $('#page-wrapper').load('ko-cabang/do_bon_gantung.php',
                  function(){
                    $("#from_date").datepicker(datePickerOptions);
                    $("#from_date").datepicker("setDate", "today");
                  });
            });
      
      //Moment Js for showing time      
      //     var interval = setInterval(function() {
      //     var momentNow = moment();
      //     $('#date-part').html(momentNow.format('DD MMMM YYYY'));
      //     $('#time-part').html(momentNow.format('kk:mm:ss'));
      // }, 100);
      });
    </script>
 </body>
</html>