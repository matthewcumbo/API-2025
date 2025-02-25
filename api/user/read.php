<?php 

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

include_once("../../core/initialize.php");

// create a new instance of the User class
$user = new User($db);

$result = $user->read();
$num = $result->rowCount();

if($num > 0){
    $users_list = array();
    $users_list['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $user_item = array(
            "id"        => $id,
            "username"  => $username,
            "email"     => $email,
            "password"  => $password,
            "firstName" => $firstName,
            "lastName"  => $lastName
        );

        array_push($users_list['data'], $user_item);
    }
    echo json_encode($users_list);
}
else{
    echo json_encode(array("message" => "No users found"));
}

?>