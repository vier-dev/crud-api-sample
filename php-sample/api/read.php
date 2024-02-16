<?php

header("Content-Type: application/json");
header("Access-Control-Allow-Method: GET");

include ('backend-function.php');

$request = $_SERVER['REQUEST_METHOD'];

if( $request == 'GET') {

    if(isset($_GET['id'])) {

        $user = getUser($_GET);
        echo $user;

    }
    else
    {
        $userList = getList();
        echo $userList;
    }

}
else {

    $data = [
        "statusCode" => 405,
        "message" => $request. "Method is not allowed"
    ];

    echo json_encode($data);
}


?>