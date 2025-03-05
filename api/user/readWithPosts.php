<?php 

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

include_once("../../core/initialize.php");

$user = new User($db);

$user->id = isset($_GET["id"]) ? $_GET["id"] : die();

$result = $user->getUserWithPosts();
$num = $result->rowCount();

if($num > 0){
    $user_info = array(
        'id'        => $user->id,
        'username'  => $user->username,
        'email'     => $user->email,
        'password'  => $user->password,
        'firstName' => $user->firstName,
        'lastName'  => $user->lastName,
        'posts'     => $user->posts
    );
    print_r(json_encode($user_info));
}
else{
    echo json_encode(array("message" => "User could not be loaded."));
}



?>