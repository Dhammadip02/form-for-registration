<?php
/*

this file contianing database configuration assuming you are runing mysql
using user "root" and password ""
*/
define('DB_SERVER','localhost');
define('DB_USERNAME','root');
define('DB_PASSWORD', '');
define('DB_NAME', 'login');


// try to conneting to database 
$conn = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_NAME);

// check the connetion 
if($conn == false){
    dir('Error: Cannot connect');
    
}


?>