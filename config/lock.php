<?php
    // session_set_cookie_params(0);
	session_start();

	if (!isset($_SESSION['user_id']))
	{
		header("Location: ../index.php"); 
        exit;
	}

    //Panggil file yang berisi library fungsi-fungsi
    require ('../config/lib.php');
    $app = new AturLogin();

    //Untuk tamplikan siapa yang login
    $user = $app->UserDetails($_SESSION['user_id']); // get user details
    //untuk melihat last loginnya 
    $time = $user->last_login;
?>