<?php
    session_start();

    session_unset();
    
    if(session_destroy())
    {  //destroying all sessions
        header("location: ../index.php");
        exit;
    }
?>
