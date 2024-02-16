<?php
error_reporting(0);

header("Content-Type: application/json");
header("Access-Control-Allow-Method: DELETE");

include ('backend-function.php');

$request = $_SERVER['REQUEST_METHOD'];

if($request == 'DELETE') {

    $deleteUser = deleteData($_GET);
    echo $deleteUser;

}
else {

    $data = [
        "statusCode" => 405,
        "message" => $request. " Method is not allowed"
    ];

    echo json_encode($data);
}
?>