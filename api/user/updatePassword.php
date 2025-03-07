<?php 

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

header("Access-Control-Allow-Methods: PATCH");
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With");

include_once("../../core/initialize.php");

$user = new User($db);

$data = json_decode(file_get_contents("php://input"));

$user->id           = $data->id;
$user->password     = $data->password;

if($user->updatePassword()){
    echo json_encode(array('message'=>'Password updated.'));
}
else{
    echo json_encode(array('message'=>'Password NOT updated.'));
}


?>