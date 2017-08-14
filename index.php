<?php
    session_start();
    if (isset($_SESSION['user_id']))
    {
        header("Location: php/dashboard.php"); 
        exit;
    }
    //open database connection
    //require ('../config/config.php');
    //Panggil file yang berisi library fungsi-fungsi
    require ('config/lib.php');
    $app = new AturLogin();
    $timezone = "Asia/Makassar";
    date_default_timezone_set($timezone);
    $today2 = date("Y-m-d H:i:s");

    $error = '';

    if (isset($_POST['login-kan'])) 
    {
        if (empty($_POST['namaInput']) || empty($_POST['pwdInput'])) 
        {
            $error = "nama user atau password tidak boleh kosong!";
        } 
        else 
        {
            //dapatkan nama user dan pwd
            $namaVar = trim($_POST['namaInput']);
            $pwdVar  = trim($_POST['pwdInput']);

            $user_id = $app->Login($namaVar, $pwdVar); // check user login

            if($user_id > 0)
            {
                $_SESSION['user_id'] = $user_id; // Set Session
                $app->LastLogin($user_id, $today2);
                header("Location: php/dashboard.php"); // Redirect user to the profile.php
                exit;                
            }
            else
            {
                $error = 'Ada kesalahan saat Login ! Periksa username dan password nya !';
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Login User</title>

    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">

<?php
// utk mencegah user menekan tombol Back
    header('Last-Modified:'.  gmdate('D, d M Y H:i:s').'GMT');
    header('Cache-Control: no-store, no-cache, must-revalidate');
    header('Cache-Control: post-check=0, pre-check=0',false);
    header('Pragma: no-cache');
//
?>

</head>

<body>

    <div class="container">
    <div class="row">
        <div class="col-md-12">
        <div class="page-header">
            <h4><p class="text-center">.:: Halaman Login ::.</p>
            <p class="text-center"><small>Aplikasi Keuangan pada Bagian Operasional.</small></p></h4>
        </div>
        </div>
    </div>
    
        <div class="row">
        <div class="col-md-4 col-sm-4 col-lg-4"></div>
            <div class="col-md-4 col-sm-4 col-lg-4">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">Silakan Login</h3>
                    </div>
                    <div class="panel-body">
                        <form role="form" action="" method="POST">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Nama User" name="namaInput" id="nama" type="text" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="pwdInput" id="pwd" type="password" value="">
                                </div>

                                <button name="login-kan" type="submit" class="btn btn-success text-center">Login</button>
                            </fieldset>
                        </form>                        
                    </div>
                </div>
                <?php
                if ($error != "") 
                {
                    echo '<div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>Error: </strong> ' . $error . '</div>';
                }
            ?>
            </div>
        </div>
    </div>

    <!-- jQuery -->
        <script src="assets/js/jquery-3.1.1.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>

</body>

</html>
