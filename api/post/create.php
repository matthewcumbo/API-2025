<?php 

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With");

include_once("../../core/initialize.php");

$post = new Post($db);

// read submitted json data from request
$data = json_decode(file_get_contents("php://input"));

// fill user properties with decoded values
$post->userId = $data->userId;
$post->title = $data->title;
$post->content = $data->content;

if($post->create()){
    echo json_encode(array("message" => "Post created."));
}
else{
    echo json_encode(array("message" => "Post not created."));
}


?>