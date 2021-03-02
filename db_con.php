<?php 


define('DBHOST', 'localhost');
define('DBUSER', 'root');
define('DBPASS', 'LimYuJie0124');
define('DBNAME', 'octa');


/*
define('DBHOST', 'sql111.epizy.com');
define('DBUSER', 'epiz_27754829');
define('DBPASS', 'MOdtENHrBacS');
define('DBNAME', 'epiz_27754829_octaportal');
*/


$db_con = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);

// Check connection
/*if($db_con){
    echo("Connection Successfull");
}*/
if($db_con === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

?>