<?php 

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

include_once("../../core/initialize.php");

$post = new Post($db);

$_GET = array_change_key_case($_GET,CASE_UPPER);
// print_r($_GET);

$post->id = isset($_GET["ID"]) ? $_GET["ID"] : die();

$result = $post->readSingle();
$num = $result->rowCount();

if($num > 0){
    $post_info = array(
        'id'        => $post->id,
        'userId'    => $post->userId,
        'title'     => $post->title,
        'content'   => $post->content
    );
    print_r(json_encode($post_info));
}
else{
    echo json_encode(array("message" => "Post could not be loaded."));
}



?>