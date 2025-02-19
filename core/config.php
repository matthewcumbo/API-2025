<?php 

// Database details
$db_name = "dbforapilectures";
$db_username = "root";
$db_password = "root";

// PDO = PHP Data Objects
// Used for Object Oriented Programming
// Creating an 'object' makes our code much more organised
$db = new PDO("mysql:host=localhost;dbname=".$db_name.";charset=utf8;",
            $db_username,
            $db_password);

// set dome db attributes
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$db->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


?>