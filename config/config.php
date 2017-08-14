<?php
/**
 * These are the database login details
 */
define("HOST", "localhost");     // The host you want to connect to.
define("USER", "root");    // The database username.
define("PASSWORD", "rtv58");    // The database password.
define("DATABASE", "koperasional");    // The database name.
define('CHARSET', 'utf8');

// define("CAN_REGISTER", "any");
// define("DEFAULT_ROLE", "member");

// define("SECURE", FALSE);    // FOR DEVELOPMENT ONLY!!!!

/*
* if you are using HTTPS in your login application set the $secure variable to true
* in a production environment it is essential that you use HTTPS
*/
function DB()
{
static $instance;
if ($instance === null) {
    $opt = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => FALSE,
    );
    $dsn = 'mysql:host=' . HOST . ';dbname=' . DATABASE . ';charset=' . CHARSET;
    $instance = new PDO($dsn, USER, PASSWORD, $opt);
}
return $instance;
}

?>
