<?php 

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

include_once("../../core/initialize.php");

// create a new instance of the User class
$post = new Post($db);

$result = $post->read();
$num = $result->rowCount();

if($num > 0){
    $posts_list = array();
    $posts_list['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $post_item = array(
            "id"        => $id,
            "userId"    => $userId,
            "title"     => $title,
            "content"   => $content
        );

        array_push($posts_list['data'], $post_item);
    }
    echo json_encode($posts_list);
}
else{
    echo json_encode(array("message" => "No posts found"));
}

?>