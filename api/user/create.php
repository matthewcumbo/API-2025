<?php 

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With");

include_once("../../core/initialize.php");

$user = new User($db);

// read submitted json data from request
$data = json_decode(file_get_contents("php://input"));

// fill user properties with decoded values
$user->username = $data->username;
$user->email = $data->email;
$user->password = $data->password;
$user->firstName = $data->firstName;
$user->lastName = $data->lastName;

if($user->create()){
    echo json_encode(array("message" => "User created."));
}
else{
    echo json_encode(array("message" => "User not created."));
}


?>