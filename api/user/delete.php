<?php 

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With");

if($_SERVER["REQUEST_METHOD"] != "DELETE"){
    http_response_code(403);
    echo json_encode(array("error" => "Wrong HTTP Method used."));
    die();
}


include_once("../../core/initialize.php");

$user = new User($db);
$post = new Post($db);

$user->id = isset($_GET['id']) ? $_GET['id'] : die();
$post->userId = isset($_GET['id']) ? $_GET['id'] : die();

if(!$post->deleteUserPosts()){
    echo json_encode(array("message" => "Could not delete user's Posts"));
    die();
}

if($user->delete()){
    echo json_encode(array("message"=>"User (including Posts) Deleted."));
}
else{
    echo json_encode(array("message"=>"Post NOT Deleted."));

}
